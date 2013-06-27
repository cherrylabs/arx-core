<?php namespace Arx;

use \Symfony\Component\Finder\Finder;

class ctrl_install extends \Arx\c_controller{

    var $name;

    protected $schemasDir = 'schemas/';

    public function _init(){

    }

    public function ioc(){

    }

    public function setup($source = 'arxConfig.php', $destination = null){

        $t = self::getInstance();

        $oFinder = new c_finder(ROOT_DIR);

        $t->aMenu = $oFinder->app->config->scan();

        $template = file_get_contents(htmlspecialchars(dirname(__DIR__).DS.$t->schemasDir.$source));

        $t->display('install', array('template' => $template));

    }

}