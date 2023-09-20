<?php
namespace Drupal\bc_old_content_notify\Controller;

use Drupal\user\Entity\User;

Class OldContentNotity {

  public static function handler() {

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
    $nodes = \Drupal::entityTypeManager()
      ->getStorage('node')
      ->loadByProperties([
        'type' => 'os2web_page',
        'moderation_state' => 'foraeldet'
      ]);

    if (count($nodes) > 0) {
      $scheme_storage = \Drupal::entityTypeManager()->getStorage('access_scheme');
      $scheme = $scheme_storage->load('adgangs_grupper');
      $user_storage = \Drupal::service('workbench_access.user_section_storage');

      foreach ($nodes as $node) {
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
      $body = null;
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
