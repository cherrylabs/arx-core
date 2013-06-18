<?php namespace Arx;

class c_view extends c_singleton {

    private static $_aInstances = array();

    private static $_motor = 'c_template';

    public function __construct(){

    }

    public static function fetch($template)
    {
        $t = new c_template();
        return $t->fetch($template);
    }

    public static function display($template)
    {
        $t = new c_template();
        return $t->display($template);
    }

}
