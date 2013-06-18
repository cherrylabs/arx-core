<?php
/**
 * Created by JetBrains PhpStorm.
 * User: danielsum
 * Date: 17/06/13
 * Time: 22:33
 * To change this template use File | Settings | File Templates.
 */

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../core.php';

class ArxTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $_SERVER['SERVER_NAME'] = 'slim';
        $_SERVER['SERVER_PORT'] = '80';
        $_SERVER['SCRIPT_NAME'] = '/foo/index.php';
        $_SERVER['REQUEST_URI'] = '/foo/index.php/bar/xyz';
        $_SERVER['PATH_INFO'] = '/bar/xyz';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['QUERY_STRING'] = 'one=1&two=2&three=3';
        $_SERVER['HTTPS'] = '';
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
        unset($_SERVER['CONTENT_TYPE'], $_SERVER['CONTENT_LENGTH']);
    }

    public function testConfig()
    {
        global $arxConfig;
        $this->assertNotNull($arxConfig);
        $this->assertNotNull($arxConfig["system"]);
        $this->assertNotNull($arxConfig["system"]["app"]);
        $this->assertNotNull($arxConfig["system"]["template"]);
        $this->assertNotNull($arxConfig["system"]["db"]);
    }

    public function testInstance()
    {
        $app = new arx();
        $this->assertObjectHasAttribute("_oTpl", $app);
        $this->assertTrue(is_object($app->tpl), "tpl is not an object");
        $this->assertTrue(is_object($app->route), "route is not an object");
    }


    public function testLoading()
    {
        $app = new arx();

        $this->assertTrue(is_object($app->h_widget()), "h_widget test is not an object");
        $this->assertTrue(is_object($app->c_finder()), "c_finder test is not an object");
    }
}

/*$test = new ArxTest();
$test->testLoading();*/
