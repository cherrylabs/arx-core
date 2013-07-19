<?php namespace Arx\controllers;

use Arx\classes\App;
use Arx\classes\Config;
use Arx\classes\Container;
use Arx\classes\Finder;

class Install extends Container {

    $view = 'install';


    public $finderConfig;

    public function _init(){
        $this->app = App::getInstance();

        $this->haveAppPath = is_dir(Config::get('paths.app'));

        if($this->haveAppPath){
            $this->finderConfig = new Finder(Config::get('paths.app').'/config');
        }
    }

    public function _before(){

    }

    public function _after(){

    }

    public function setup(){
        $this->_init();

    }
}