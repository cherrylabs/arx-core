<?php namespace Arx;

/**
 * Class SingletonTrait
 *
 * Simple singleton trait
 *
 * @package Arx
 *
 */
trait SingletonTrait {

    private static $_aInstances = array();

    public static function getInstance(){
        $sClass = get_called_class();

        if (!isset(self::$_aInstances[$sClass])) {
            self::$_aInstances[$sClass] = new $sClass;
        }

        return self::$_aInstances[$sClass];
    }
}