<?php

/**
 * Class ArxTest
 */
class ArxTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $_SERVER['SERVER_NAME'] = 'arx';
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
        $this->assertNotNull(\Arx\classes\Config::get(), 'Config::get() should return an array with all the configuration!');

        \Arx\classes\Config::set('level1.level2.level3.level4.level5', 'arg5');
        \Arx\classes\Config::load(__DIR__.'/../src/config/');

        $config = \Arx\classes\Config::get();

        $this->assertSame(
            $config["level1"]["level2"]['level3']['level4']['level5'],
            \Arx\classes\Config::get('level1.level2.level3.level4.level5')
        );
    }

    public function testInstance()
    {
        // $app = new \Arx\classes\App();
        // $this->assertObjectHasAttribute("_oTpl", $app);
        // $this->assertTrue(is_object($app->tpl), "tpl is not an object");
        // $this->assertTrue(is_object($app->route), "route is not an object");
    }


    public function testLoading()
    {
        // $app = new \Arx\classes\App();

        // $this->assertTrue(is_object($app->c_finder()), "c_finder test is not an object");
    }
}

/*$test = new ArxTest();
$test->testLoading();*/
