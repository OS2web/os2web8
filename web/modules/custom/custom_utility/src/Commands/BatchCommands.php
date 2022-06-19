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
    $this->output()->writeln("start \n");

    $nodes = \Drupal::entityTypeManager()
        ->getStorage('node')
        ->loadByProperties([
          'type' => 'os2web_page'
        ]);

    if (count($nodes) > 0 )
    {
      $this->writeln(count($nodes));

      $scheme_storage = \Drupal::entityTypeManager()->getStorage('access_scheme');
      $scheme = $scheme_storage->load('adgangs_grupper');
      $user_storage = \Drupal::service('workbench_access.user_section_storage');

      $outdated = array();
      foreach ( $nodes AS $node )
      {
        $state = $node->moderation_state->value;
        if (gettype($state) === 'string' && $state === 'foraeldet')
        {
          $contentGroup = $node->get('field_indholdsgruppe')->getValue()[0]['target_id'];
          if (!empty((int) $contentGroup))
          {
            $this->output()->writeln('# node ' . $node->id());
            $this->output()->writeln('# indholdsgruppe ' . $contentGroup);

            $entites = $user_storage->getEditors($scheme, $contentGroup);
            if (count($entites))
            {
              foreach ($entites AS $userId => $userName) {

              }
            }

          $this->output()->writeln('# users ' . print_r( $entites , true ));
// print_r( $entity );



          }
        }
      }


    }

    $this->output()->writeln("\nDone\n");

  }

}
