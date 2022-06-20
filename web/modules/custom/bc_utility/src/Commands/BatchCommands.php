<?php
namespace Drupal\bc_utility\Commands;

use Drush\Commands\DrushCommands;
use Drupal\bc_utility\Controller\OldContentNotify;

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
    \Drupal::logger('bc_utility')->notice('bellcom utility cron start');

    \Drupal\bc_utility\Controller\OldContentNotity::handler();
  }

}
