<?php

namespace Drupal\bc_old_content_notify\Commands;

use Drush\Commands\DrushCommands;
use Drupal\bc_old_content_notify\Controller\OldContentNotify;

class BatchCommands extends DrushCommands {

  /**
   * old content notify cron run
   *
   * @command ocf:run
   * @aliases ocfc
   * @options $options arr AN option that takes multiple values.
   */
  public function run($options = array())
  {
    OldContentNotify::handler();
  }
}
