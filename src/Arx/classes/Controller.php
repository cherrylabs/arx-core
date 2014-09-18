<?php namespace Arx\classes;

/**
 * Class Controller
 *
 * extends Laravel controller
 *
 * @todo make it usable outside Laravel
 * @package Arx\classes
 */
class Controller extends \Illuminate\Routing\Controller {

    public function display($file, $data = array()){
        $this['app']['view']->display($file, $data);
    }

}