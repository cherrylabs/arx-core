<?php

use Mockery as m;
use Arx\classes\Request;
use Arx\classes\App;

class AppTest extends PHPUnit_Framework_TestCase {

    public function tearDown()
    {
        m::close();
    }


    public function testEnvironmentDetection()
    {
        $app = m::mock('Arx\classes\App[runningInConsole]');
        $app['request'] = m::mock('Symfony\Component\HttpFoundation\Request');
        $app['request']->shouldReceive('getHost')->andReturn('foo');
        $app['request']->server = m::mock('StdClass');
        $app['request']->server->shouldReceive('get')->once()->with('argv')->andReturn(array());
        $app->shouldReceive('runningInConsole')->once()->andReturn(false);
        $app->detectEnvironment(array(
            'local'   => array('localhost')
        ));
        $this->assertEquals('production', $app['env']);

        $app = m::mock('Arx\classes\App[runningInConsole]');
        $app['request'] = m::mock('Symfony\Component\HttpFoundation\Request');
        $app['request']->shouldReceive('getHost')->andReturn('localhost');
        $app['request']->server = m::mock('StdClass');
        $app['request']->server->shouldReceive('get')->once()->with('argv')->andReturn(array());
        $app->shouldReceive('runningInConsole')->once()->andReturn(false);
        $app->detectEnvironment(array(
            'local'   => array('localhost')
        ));
        $this->assertEquals('local', $app['env']);

        $app = m::mock('Arx\classes\App[runningInConsole]');
        $app['request'] = m::mock('Symfony\Component\HttpFoundation\Request');
        $app['request']->shouldReceive('getHost')->andReturn('localhost');
        $app['request']->server = m::mock('StdClass');
        $app['request']->server->shouldReceive('get')->once()->with('argv')->andReturn(array());
        $app->shouldReceive('runningInConsole')->once()->andReturn(false);
        $app->detectEnvironment(array(
            'local'   => array('local*')
        ));
        $this->assertEquals('local', $app['env']);

        $app = m::mock('Arx\classes\App[runningInConsole]');
        $app['request'] = m::mock('Symfony\Component\HttpFoundation\Request');
        $app['request']->shouldReceive('getHost')->andReturn('localhost');
        $app['request']->server = m::mock('StdClass');
        $app['request']->server->shouldReceive('get')->once()->with('argv')->andReturn(array());
        $app->shouldReceive('runningInConsole')->once()->andReturn(false);
        $host = gethostname();
        $app->detectEnvironment(array(
            'local'   => array($host)
        ));
        $this->assertEquals('local', $app['env']);
    }

}