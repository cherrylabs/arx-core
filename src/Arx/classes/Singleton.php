<?php namespace Arx\classes;

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
    // --- Private members

    private static $_aInstances = array();

    // --- Constructor

    protected function __construct() {} // __construct


    // --- Public methods

    public static function getInstance()
    {

        Debug::deprecated(1.0, 'Standard PSR-2');

    } // getInstance

    public static function instance(){
        $sClass = get_called_class();

        if (!isset(self::$_aInstances[$sClass])) {
            self::$_aInstances[$sClass] = new $sClass;
        }

        return self::$_aInstances[$sClass];
    }

} // class::Singleton
