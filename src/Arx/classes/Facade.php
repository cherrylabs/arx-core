<?php namespace Arx\classes;

use Mockery\MockInterface;
use Illuminate\Support\Facades\Facade as ParentClass;

class Facade extends ParentClass
{
    /**
     * Auto-resolve function
     *
     */
    public static function resolve(){

        $aArgs = func_get_args();

        $aDebug = debug_backtrace(1);

        if(isset($aDebug[1])){

            $oDebug = $aDebug[1];

            $function = $oDebug['function'];
            $class = $oDebug['class'];

            if(!empty($aArgs)){
                $args = $aArgs;
            } else {
                $args = $oDebug['args'];
            }

            $app = $class::getFacadeApplication();

            return call_user_func_array( array($app[$class::getFacadeAccessor()], $function), $args);
        } else {
            Throw new Exception('Cannot resolve this function');
        }
    }

}