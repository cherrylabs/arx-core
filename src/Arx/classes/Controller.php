<?php namespace Arx\classes;

use Illuminate\Routing\Controllers\Controller as ParentClass;

/**
 * Class Controller
 *
 * extends Laravel controller
 *
 * @todo make it usable outside Laravel
 * @package Arx\classes
 */
class Controller extends ParentClass {

    public function display($file, $data = array()){
        $this['app']['view']->display($file, $data);
    }
}