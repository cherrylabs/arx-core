<?php namespace Arx;

use \Symfony\Component\Finder\Finder;

class ctrl_install extends \Arx\c_controller{

    var $name;

    public function _init(){
        $this->display('install');
    }

    public function ioc(){

    }

    public function setup($schema = null){

        $t = self::getInstance();

        $object = new c_finder();

        predie($object->app->config->scan());

        $t->display('install');

    }

}