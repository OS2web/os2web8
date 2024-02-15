<?php
namespace Drupal\bc_basic\Commands;

use Drush\Commands\DrushCommands;
use Drupal\bc_basic\Debug;

Class BatchCommands extends DrushCommands
{

    /**
     * bellcom test
     *
     * @command bc:test
     * @aliases bctest
     * @options $options arr AN option that takes multiple values.
     */
    public function test($options=array())
    {
        echo "bellcom test\n";
        Debug::log(__METHOD__ );

    }

}
