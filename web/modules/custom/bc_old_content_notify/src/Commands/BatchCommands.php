<?php

namespace Drupal\bc_old_content_notify\Commands;


use Drush\Commands\DrushCommands;
use Drupal\bc_old_content_notify\Controller\OldContentNotity;

class BatchCommands extends DrushCommands
{

  /**
   * old content notify test run
   *
   * @command ocf:test
   * @aliases ocf
   * @options $options arr AN option that takes multiple values.
   */
  public function testRun($options = array())
  {
    echo "test run\n";
  }

  /**
   * old content notify cron run
   *
   * @command ocf:run
   * @aliases ocfc
   * @options $options arr AN option that takes multiple values.
   */
  public function run($options = array())
  {
    OldContentNotity::handler();
  }



}
