<?php
namespace Drupal\bc_utility\Controller;

use Drupal\content_moderation\Plugin\WorkflowType\ContentModeration;
use Drupal\content_moderation_notifications\Entity\ContentModerationNotification;
use Drupal\Core\Mail\MailFormatHelper;

Class OldContentNotity
{

  public static function handler()
  {
    $outdated = array();
    $nodes = \Drupal::entityTypeManager()
      ->getStorage('node')
      ->loadByProperties([
        'type' => 'os2web_page'
      ]);

    if (count($nodes) > 0 )
    {
      $scheme_storage = \Drupal::entityTypeManager()->getStorage('access_scheme');
      $scheme = $scheme_storage->load('adgangs_grupper');
      $user_storage = \Drupal::service('workbench_access.user_section_storage');

      foreach ( $nodes AS $node )
      {
        $state = $node->moderation_state->value;
        if (gettype($state) === 'string' && $state === 'foraeldet')
        {
          $contentGroup = $node->get('field_indholdsgruppe')->getValue()[0]['target_id'];

          if (!empty((int) $contentGroup))
          {
            $entites = $user_storage->getEditors($scheme, $contentGroup);
            if (count($entites))
            {
              foreach ($entites AS $userId => $userName)
              {
                $user = \Drupal\user\Entity\User::load($userId);
                if (!empty($user->get('mail')->value))
                {
                  if (empty($outdated[$user->id()]))
                  {
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
    }

    if (count($outdated))
    {
      // TODO get mail from Content Moderation notification
//      $id = 'email_brugere_ved_foraeldede_sider';
//      $ContentModerationNote = ContentModerationNotification::load($id);
//      $subject = $ContentModerationNote->getSubject();
//      $body = $ContentModerationNote->getMessage();

      $mailManager = \Drupal::service('plugin.manager.mail');
      $module = 'bc_utiltity';
      $key = 'old_article';
      $langcode = 'da';
      $send = true;
      $body = null;
      $params = array(
        'subject' => 'A page is outdated',
        'body' => null,
        'headers' => array(
          'Content-Type' => 'text/html; charset=UTF-8; format=flowed; delsp=yes'
        )
      );

      foreach ( $outdated AS $user )
      {
        $body = '<p>Hej ' . $user['name'] . '</p>';
        foreach ( $user['outdated'] as $page )
        {
          $body .= '<p>Siden <em>' . $page['title'] . '</em> er forældet. <a href="' . $page['link'] . '" target="_blank">Link</a></p>';
        }

        $params['body'] = $body;

        $result = $mailManager->mail(
          'bc_utility',
          'old_article',
          $user['email'],
          $langcode,
          $params,
          null,
          true
        );

        if ($result['result'] !== true)
        {
          \Drupal::logger('bc_utility')->notice('old content email could not be sent to ' . $user['email']);
        }
        else
        {
          \Drupal::logger('bc_utility')->notice('old content email is sent to ' . $user['email']);
        }

      }
    }
  }

}
