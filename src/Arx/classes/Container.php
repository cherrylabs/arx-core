<?php namespace Arx\classes;

use Illuminate\Container\Container as ParentClass;
use ArrayAccess;

/**
 * Class Container
 *
 * extends Illuminate\Container\Container class add possibility to getInstance (Singleton pattern)
 *
 * @package Arx\classes
 */
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