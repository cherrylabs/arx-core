<?php

class c_singleton
{
    private static $_aInstances = array();

    final public static function getInstance()
    {
        $sClass = get_called_class();

        if ( !isset( self::$_aInstances[ $sClass ] ) ){
            self::$_aInstances[ $sClass ] = new $sClass;
        }

        return self::$_aInstances[ $sClass ];
    } // getInstance

    final public function __clone()
    {
        throw new Exception( "Cloning is not authorized." );
    } // __clone

    protected function __construct() {} // __construct

} // class::Singleton