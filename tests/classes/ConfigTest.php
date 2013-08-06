<?php
/**
 * ConfigTest.php.
 * @project : arx
 * @author : danielsum
 */

use Arx\classes\Config;

class ConfigTest extends PHPUnit_Framework_TestCase {

    public function testLoad(){
        $config = Config::load(__DIR__ . '/../config');
        $this->assertNotNull($config, 'Config should not be null');
    }

    public function testDetectEnvironment(){

    }
}
