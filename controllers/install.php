<?php namespace Arx;

class ctrl_install extends \Arx\c_controller{

    var $name;

    public function _init(){
        $this->display('install');
    }

    public function ioc(){

    }

    public function setup($schema = null){

        $t = self::getInstance();

        $t->display('install');

    }

}