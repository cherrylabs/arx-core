<?php
/**
 * ConfigTest.php.
 * @project : arx
 * @author : danielsum
 */

use Arx\classes\Config;

class ConfigTest extends PHPUnit_Framework_TestCase {

    public function testLoad(){
        $config = Config::load('../config');
        $this->assertNotNull($config, 'Config is null');
    }
}
