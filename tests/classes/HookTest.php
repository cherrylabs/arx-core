<?php

use Arx\classes\Hook;

/**
 * Class HookTest
 */
class HookTest extends PHPUnit_Framework_TestCase {

    public function testHook(){

        Hook::register('test');

        Hook::add('test', 'test');

        $this->assertNotNull(Hook::get('test'), 'Hook is null !');
    }

}