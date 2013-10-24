<?php namespace Arx\traits;

trait getInstance(){
    $sClass = get_called_class();

    if (!isset(self::$_aInstances[$sClass])) {
        self::$_aInstances[$sClass] = new $sClass;
    }

    return self::$_aInstances[$sClass];
}