<?php

namespace Drupal\bc_old_content_notify\Controller;

use Drupal\node\NodeInterface;
use Drupal\user\Entity\User;

class OldContentController {

  /**
   * Updates the moderation state of outdated content based on specific criteria.
   */
  public static function contentModerationStateCheck() {
    $config = \Drupal::config('bc_old_content_notify.settings');
    if (!$config->get('enabled')) {
      return;
    }

    // The default value is 120 days = 4 months.
    $outdatedDays = $config->get('days_since_last_edit') ?? 120;
    $outdatePeriod = \Drupal::time()->getRequestTime() - ($outdatedDays * 24 * 60 * 60);

    $nids = \Drupal::entityQuery('node')
      ->accessCheck(FALSE)
      ->latestRevision()
      ->condition('status', 1)
      ->condition('type', 'os2web_page')
      ->condition('changed', $outdatePeriod, '<')
      ->addTag('bc_old_content_not_outdated_state')
      ->execute();

    $stateOutdated = 'foraeldet';

    $storage = \Drupal::entityTypeManager()->getStorage('node');

    foreach ($nids as $nid) {
      /** @var \Drupal\node\NodeInterface|null $node */
      $node = $storage->load($nid);

      if (!$node instanceof NodeInterface || !$node->hasField('moderation_state')) {
        continue;
      }

      $node->setNewRevision(TRUE);
      $node->setRevisionTranslationAffected(TRUE);
      $node->isDefaultRevision(TRUE);
      $node->set('moderation_state', $stateOutdated);

      $node->save();
    }
  }

  public static function notify() {
    $config = \Drupal::config('bc_old_content_notify.settings');
    if (!$config->get('enabled')) {
      return;
    }

    $doRun = false;
    $last_start = \Drupal::keyValue('bc_old_content_notify_cron')->get('last_start');

    if (empty($last_start)) {
      $doRun = true;
    }
    else {
      $next = null;

      switch ($config->get('run')) {
        case 1:
          $next = strtotime("+1 day", $last_start);
          break;

        case 2:
          $next = strtotime("+1 week", $last_start);
          break;

        case 3:
          $next = strtotime("+1 month", $last_start);
          break;

        case 4:
          $next = strtotime("+1 year", $last_start);
          break;

        default:
          $next = null;
      }

      if ($next && $next <= time()) {
        $doRun = true;
      }
    }

    if (!$doRun) {
      return;
    }

    \Drupal::keyValue('bc_old_content_notify_cron')->set('last_start', time());

    $outdated = [];

    $nids = \Drupal::entityQuery('node')
      ->latestRevision()
      ->accessCheck(FALSE)
      ->condition('type', 'os2web_page')
      ->addTag('bc_old_content_outdated_state')
      ->execute();

    if (count($nids) > 0) {
      $scheme_storage = \Drupal::entityTypeManager()->getStorage('access_scheme');
      $scheme = $scheme_storage->load('adgangs_grupper');
      $user_storage = \Drupal::service('workbench_access.user_section_storage');
      $storage = \Drupal::entityTypeManager()->getStorage('node');

      foreach ($nids as $nid) {
        /** @var \Drupal\node\NodeInterface|null $node */
        $node = $storage->load($nid);

        if (!$node instanceof NodeInterface) {
          continue;
        }

        $contentGroup = $node->get('field_indholdsgruppe')->isEmpty()
          ? null
          : $node->get('field_indholdsgruppe')->target_id;

        if (!empty((int) $contentGroup)) {
          $entities = $user_storage->getEditors($scheme, $contentGroup);

          if (count($entities)) {
            foreach ($entities as $userId => $userName) {
              $user = User::load($userId);

              if ($user && !empty($user->get('mail')->value)) {
                if (empty($outdated[$user->id()])) {
                  $outdated[$user->id()]['name'] = $user->get('name')->value;
                  $outdated[$user->id()]['email'] = $user->get('mail')->value;
                  $outdated[$user->id()]['outdated'] = [];
                }

                $outdated[$user->id()]['outdated'][] = [
                  'title' => $node->label(),
		  'link' => $node->toUrl()->setAbsolute(TRUE)->toString(),
  		  'author' => $node->getOwner()->label(),
  		  'group' => !$node->get('field_indholdsgruppe')->isEmpty()
    		    ? $node->get('field_indholdsgruppe')->entity->label()
		    : '',
         	  'html' => '
            	    <tr style="border-bottom:1px solid #ddd;">
              	      <td style="padding:6px;">
                        <a href="' . $node->toUrl()->setAbsolute(TRUE)->toString() . '" target="_blank">
                          ' . $node->label() . '
                        </a>
                      </td>
                      <td style="padding:6px;">
                        ' . $node->getOwner()->label() . '
                      </td>
                      <td style="padding:6px;">
                        ' . (
                          !$node->get('field_indholdsgruppe')->isEmpty()
                            ? $node->get('field_indholdsgruppe')->entity->label()
                            : '-'
                        ) . '
                      </td>
                   </tr>',
                ];
              }
            }
          }
        }
      }
    }

    if (count($outdated) > 0) {
      $mailManager = \Drupal::service('plugin.manager.mail');
      $langcode = 'da';

      $params = [
        'subject' => 'Månedligt overblik – forældede sider',
        'body' => null,
        'headers' => [
          'Content-Type' => 'text/html; charset=UTF-8; format=flowed; delsp=yes',
        ],
      ];

      // Tilpas dette link, hvis "Forældede sider"-overblikket har en anden URL.
      $overview_link = \Drupal::request()->getSchemeAndHttpHost() . '/admin/content/foraeldede-sider';

      foreach ($outdated as $user) {
        $body = '';

        $body .= '<p>Kære webredaktør</p>';

        $body .= '<p>Som en del af vores løbende kvalitetsarbejde får du her den månedlige oversigt over sider på hjemmesiden, som ikke har været opdateret inden for de seneste 365 dage.</p>';

        $body .= '<p>Formålet er at sikre, at vores indhold altid er opdateret, korrekt og meningsfuldt for brugerne.</p>';

        $body .= '<p>Vi beder dig derfor om at gennemgå siderne i listen herunder og vurdere, om de:</p>';

        $body .= '<ul>';
        $body .= '<li>skal opdateres</li>';
        $body .= '<li>kan arkiveres eller slettes</li>';
        $body .= '<li>fortsat er relevante, som de er</li>';
        $body .= '</ul>';

        $body .= '<p><a href="' . $overview_link . '" target="_blank">Gå direkte til ”Forældede sider” overblikket</a></p>';


        $body .= '<p>Har du spørgsmål eller brug for hjælp, er du som altid velkommen til at kontakte os.</p>';

        $body .= '<p>Tak for din indsats med at holde vores hjemmeside opdateret.</p>';

        $body .= '<p>Venlig hilsen<br>Webteamet</p>';

        if (!empty($user['outdated'])) {
          $body .= '<h3>Forældede sider</h3>';
          $body .= '<ul>';

          foreach ($user['outdated'] as $page) {
	    $body .= '<li>';
	    $body .= '<a href="' . $page['link'] . '" target="_blank">' . $page['title'] . '</a>';
	    $body .= ' — Forfatter: ' . $page['author'];

	    if (!empty($page['group'])) {
	      $body .= ' — Indholdsgruppe: ' . $page['group'];
	    } 
	  }

          $body .= '</ul>';
        }


        $params['body'] = $body;

        $result = $mailManager->mail(
          'bc_old_content_notify',
          'old_article',
          $user['email'],
          $langcode,
          $params,
          null,
          true
        );

        if ($result['result'] !== true) {
          \Drupal::logger('bc_old_content_notify')->notice('old content email could not be sent to ' . $user['email']);
        }
        else {
          \Drupal::logger('bc_old_content_notify')->notice('old content email is sent to ' . $user['email']);
        }

        // stan@bellcom.dk 22/12/2025 - stop after the first email.
        return;
      }
    }
  }

}
