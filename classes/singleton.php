<?php
/** La Cerise Numérique : ARX
 * /arx/classes/singleton.php
 */

class c_singleton
{
    private static $_aInstances = array();

    final public static function getInstance()
    {
        $sClass = get_called_class();

        if( !isset( self::$_aInstances[ $sClass ] ) )	self::$_aInstances[ $sClass ] = new $sClass;

        return self::$_aInstances[ $sClass ];
    } // getInstance

    final public function __clone()
    {
        throw new Exception( "Cloning is not authorized." );
    } // __clone

    protected function __construct() {} // __construct

} // class::Singleton

// get_called_class() is only in PHP >= 5.3.
if ( !function_exists('get_called_class') ) {
    function get_called_class()
    {
        $bt = debug_backtrace();
        $l = 0;
        do {
            $l++;
            $lines = file( $bt[$l]['file'] );
            $callerLine = $lines[ $bt[$l]['line'] - 1 ];
            preg_match('/([a-zA-Z0-9\_]+)::' . $bt[$l]['function'] . '/', $callerLine, $matches);
        } while ($matches[1] === 'parent' && $matches[1]);

        return $matches[1];
    }
}
