<?php
namespace Drupal\bc_speedadmin\Commands;

use Drush\Commands\DrushCommands;

Class BatchCommands extends DrushCommands
{

    /**
     * speedadmin test run
     *
     * @command sd:test
     * @aliases sdt
     * @options $options arr AN option that takes multiple values.
     */
    public function testRun($options=array())
    {
        echo "test run\n";


    }


}