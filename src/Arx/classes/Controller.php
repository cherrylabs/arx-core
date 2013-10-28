<?php namespace Arx\classes;

use Illuminate\Routing\Controllers\Controller as ParentClass;

class Controller extends ParentClass {

    public function display($file, $data = array()){
        $this['app']['view']->display($file, $data);
    }
}