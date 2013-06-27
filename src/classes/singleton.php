<?php namespace Arx\classes;

class Singleton
{
    private static $_aInstances = array();
    public $_clonable = true;

    public static function getInstance()
    {
        $sClass = get_called_class();

        if (!isset(self::$_aInstances[$sClass])) {
            self::$_aInstances[$sClass] = new $sClass;
        }

        return self::$_aInstances[$sClass];
    } // getInstance

    public function __clone()
    {
        if (!$this->_clonable) {
            throw new Exception( "Cloning is not authorized." );
        }
    } // __clone

} // class::Singleton

class_alias('Arx\classes\Singleton', 'c_singleton');

