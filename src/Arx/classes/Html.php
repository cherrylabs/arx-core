<?php namespace Arx\classes;

use Illuminate\Html\HtmlBuilder;

/**
 * Class Html
 *
 * Extends Illuminate HTML class
 *
 * @package Arx\classes
 */
class Html extends Singleton {

    protected $html;

    public function __construct(){
        $this->html = new HtmlBuilder();
    }

    public static function __callStatic($name, $args){
        $html = self::getInstance()->html;
        return call_user_func_array(array($html, $name), $args);
    }

}
