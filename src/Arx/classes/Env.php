<?php namespace Arx\classes;
/**
 * Class Env
 *
 * Env class helpers
 *
 * @package Arx\classes
 */
class Env {

    public static function detect(){

        $file = Composer::getRootPath('/app/config/env.php');

        if(is_file($file)) {
            $config = include $file;
        } else {
            $config = include dirname(__DIR__).'/../config/env.php';
        }

        if(defined('ZE_ENV')){

            return ZE_ENV;

        } elseif(isset($_SERVER['ZE_ENV'])){

            define('ZE_ENV', $_SERVER['ZE_ENV']);

            return ZE_ENV;

        } elseif(is_array($config)) {

            $env = 'production';

            foreach($config as $key => $value){
                if(is_callable($value) && $value instanceof \Closure && $value()){
                    $env = $key;
                } elseif(is_string($value)) {
                    // Not the safest way !
                    if(preg_match($value, getenv('HTTP_HOST') )){
                        $env = $key;
                    }
                }
            }

            define('ZE_ENV', $env);

            return ZE_ENV;


        }
    }

}