<?php namespace Arx\classes;

class Controller extends Container {

    public function __construct()
    {
         $this['app'] = App::getInstance();
    }

    public function display($file, $data = array()){
        $this['app']['view']->display($file, $data);
    }
}