<?php namespace Arx\classes;

use Illuminate\Container\Container as ParentClass;
use ArrayAccess, Closure;

class Container extends ParentClass implements ArrayAccess {

    protected static $_aInstances = array();

    public static function getInstance(){
        $sClass = get_called_class();

        if (!isset(self::$_aInstances[$sClass])) {
            self::$_aInstances[$sClass] = new $sClass;
        }

        return self::$_aInstances[$sClass];
    }
}