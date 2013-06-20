<?php namespace Arx;

class c_singleton
{
    private static $_aInstances = array();

    public static function getInstance()
    {
        $sClass = get_called_class();

        if ( !isset( self::$_aInstances[ $sClass ] ) ){
            self::$_aInstances[ $sClass ] = new $sClass;
        }

        return self::$_aInstances[ $sClass ];
    } // getInstance

    public function __clone()
    {
        throw new Exception( "Cloning is not authorized." );
    } // __clone

    protected function __construct() {} // __construct

} // class::Singleton

class_alias('\Arx\c_singleton', 'c_singleton');