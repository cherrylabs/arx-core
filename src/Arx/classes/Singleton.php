<?php namespace Arx\classes;

/**
 * Singleton
 *
 * Simple Singleton class design pattern
 *
 * @category Utils
 * @package  Arx
 * @author   Daniel Sum <daniel@cherrypulp.com>
 * @author   Stéphan Zych <stephan@cherrypulp.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @link     http://arx.xxx/doc/Singleton
 */
class Singleton
{

    private static $_aInstances = array();

    public static function getInstance(){
        $sClass = get_called_class();

        if (!isset(self::$_aInstances[$sClass])) {
            self::$_aInstances[$sClass] = new $sClass;
        }

        return self::$_aInstances[$sClass];
    }

} // class::Singleton
