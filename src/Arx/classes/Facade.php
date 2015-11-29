<?php namespace Arx\classes;

use Illuminate\Support\Facades\Facade as ParentClass;

/**
 * Class Facade
 *
 * Extends the Laravel Facade class and adding a smart resolve method,
 * so you can modify params before sending to the parent method and get CodeIntelligence in your IDE
 *
 * @example
 *
 * class CustomClass extends Arx\classes\Facade{
 *
 * public static function methodOfFacadeApplication($myArgument){
 *
 *      return self::resolve();
 * }
 *
 * }
 *
 * @package Arx\classes
 */
class Facade extends ParentClass
{
    /**
     * Auto-resolve function
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
            Throw new \Exception('Cannot resolve this function');
        }
    }

}