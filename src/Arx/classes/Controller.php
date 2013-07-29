<?php namespace Arx\classes;

class Controller extends \Controller {

    public function display($file, $data = array()){
        $this['app']['view']->display($file, $data);
    }
}