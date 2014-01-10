<?php namespace Arx\classes;

use Illuminate\Html\FormBuilder as ParentClass;
use Illuminate\Support\Facades\Facade;

/**
 * Class Html
 *
 * Extends Illuminate HTML class
 *
 * @package Arx\classes
 */
class Form extends Singleton {

    protected $html;

    public function __construct(){
        $this->html = new ParentClass();
    }
    
    function __callStatic($name, $args){
        $html = self::getInstance()->html;
        return call_user_func_array(array($html, $name), $args);
    }

}