<?php
namespace Drupal\custom_utility\Commands;

use Drush\Commands\DrushCommands;

Class BatchCommands extends DrushCommands
{

  /**
   * Search node with foraeldet status
   *
   *
   * @command old:notify
   * @aliases oln
   * @options $options arr AN option that takes multiple values.
   */
  public function oldContentNotify($options=array())
  {
    // $this->output()->writeln("start \n");

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

                  $outdated[$user->id()]['outdated'][] = $node->toUrl()->setAbsolute(true)->toString();
                }
              }
            }
          }
        }
      }
      // $this->output()->writeln('# users ' . print_r( $outdated , true ));
    }

    if (count($outdated))
    {
      // TODO send email
    }

  }

}
