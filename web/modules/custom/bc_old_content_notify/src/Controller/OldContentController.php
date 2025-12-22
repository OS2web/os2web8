<?php
namespace Drupal\bc_old_content_notify\Controller;

use Drupal\node\NodeInterface;
use Drupal\user\Entity\User;

class OldContentController {

  /**
   * Updates the moderation state of outdated content based on specific criteria.
   *
   * Calculates the time period for content to be considered outdated,
   * and fetches nodes matching the outdated criteria.
   *
   * The moderation state of these nodes is then updated to a predefined value
   * and saved as a new revision.
   */
  public static function contentModerationStateCheck() {
    $config = \Drupal::config('bc_old_content_notify.settings');
    if (!$config->get('enabled')) return;

    // The default value is 120 days = 4 months.
    $outdatedDays = $config->get('days_since_last_edit') ?? 120;
    $outdatePeriod = \Drupal::time()->getRequestTime() - ($outdatedDays * 24 * 60 * 60);

    $nids = \Drupal::entityQuery('node')
      ->accessCheck(FALSE)
      ->condition('type', 'os2web_page')
      ->condition('changed', $outdatePeriod, '<')
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
    if (!$config->get('enabled')) return;

    $doRun = false;
    $last_start = \Drupal::keyValue('bc_old_content_notify_cron')->get('last_start');

    if (empty($last_start)) $doRun = true;
    else {

      $next = null;
      switch ($config->get('run')) {
        case 1 : $next = strtotime("+1 day", $last_start); break;
        case 2 : $next = strtotime("+1 week", $last_start); break;
        case 3 : $next = strtotime("+1 month", $last_start); break;
        case 4 : $next = strtotime("+1 year", $last_start); break;
        default: $next = null;
      }

      if ($next && $next <= time()) {
        $doRun = true;
      }

    }

    if (!$doRun) return;

    \Drupal::keyValue('bc_old_content_notify_cron')->set('last_start', time());

    $outdated = array();
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
        $node = $storage->load($nid);
        if (!$node) {
          continue;
        }

        $contentGroup = $node->get('field_indholdsgruppe')->getValue()[0]['target_id'];

        if (!empty((int)$contentGroup)) {
          $entites = $user_storage->getEditors($scheme, $contentGroup);
          if (count($entites)) {
            foreach ($entites as $userId => $userName) {
              $user = User::load($userId);
              if (!empty($user->get('mail')->value)) {
                if (empty($outdated[$user->id()])) {
                  $outdated[$user->id()]['name'] = $user->get('name')->value;
                  $outdated[$user->id()]['email'] = $user->get('mail')->value;
                  $outdated[$user->id()]['outdated'] = array();
                }

                $outdated[$user->id()]['outdated'][] = array(
                  "title" => $node->label(),
                  "link" => $node->toUrl()->setAbsolute(true)->toString()
                );
              }
            }
          }
        }
      }
    }

    if (count($outdated) > 0) {
      $mailManager = \Drupal::service('plugin.manager.mail');
      $langcode = 'da';

      $params = array(
        'subject' => 'En eller flere sider er foraeldet',
        'body' => null,
        'headers' => array(
          'Content-Type' => 'text/html; charset=UTF-8; format=flowed; delsp=yes'
        )
      );

      foreach ($outdated as $user) {
        $body = '<p>Hej ' . $user['name'] . '</p>';
        foreach ($user['outdated'] as $page) {
          $body .= '<p>Siden <em>' . $page['title'] . '</em> er forældet. <a href="' . $page['link'] . '" target="_blank">Link</a></p>';
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
        } else {
          \Drupal::logger('bc_old_content_notify')->notice('old content email is sent to ' . $user['email']);
        }
      }
    }
  }
}
