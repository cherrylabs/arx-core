<?php
/**
 * Test.php.
 * @project : arx
 * @author  : danielsum
 */

use Arx\classes\Hook;

class HookTest extends PHPUnit_Framework_TestCase
{

    public function testBag()
    {
        $hook = Hook::add('css', array(

        ));
    }
}