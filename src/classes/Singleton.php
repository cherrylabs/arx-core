<?php namespace Arx/classes;

/**
 * Singleton
 *
 * PHP File - /classes/Singleton.php
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
    // --- Constructor

    protected function __construct() {} // __construct


    // --- Public methods

    final public static function getInstance()
    {
        $sClass = get_called_class();

        if (!isset(self::$_aInstances[$sClass])) {
            self::$_aInstances[$sClass] = new $sClass;
        }

        return self::$_aInstances[$sClass];
    } // getInstance


    // --- Private members

    private static $_aInstances = array();

} // class::Singleton
