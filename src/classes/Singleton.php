<?php namespace Arx/classes;
/**
 * ARX The refexive kit.
 *
 * PHP File - /classes/Singleton.php
 *
 * @package         arx
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
