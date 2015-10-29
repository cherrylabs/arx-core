<?php namespace Arx\classes;
/**
 * Class Env
 *
 * Env class helpers
 *
 * @package Arx\classes
 */
class Env {

    /**
     * Smarter way to get config env
     *
     * @return int|string
     */
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

                    if(preg_match('/\//i', $value)){
                        // Not the safest way !
                        if(preg_match($value, getenv('HTTP_HOST') )){
                            $env = $key;
                        }
                    } else {
                        if(preg_match('/'.$value.'/i', getenv('HTTP_HOST') )){
                            $env = $key;
                        }
                    }
                }
            }

            define('ZE_ENV', $env);

            return ZE_ENV;
        }
    }

    /**
     * Define level environment
     *
     * Detect a env level
     * @return int
     */
    public static function level()
    {
        if(defined('ZE_LEVEL_ENV')){
            return ZE_LEVEL_ENV;
        } else {
            $env = self::detect();

            switch($env){
                case 'console':
                    $level_env = 0;
                    break;
                case 'local':
                    $level_env = 1;
                    break;
                case 'dev':
                    $level_env = 2;
                    break;
                case 'demo':
                    $level_env = 3;
                    break;
                default :
                    $level_env = 4;
                    break;
            }

            define('ZE_LEVEL_ENV', $level_env);
        }

        return ZE_LEVEL_ENV;
    }
}