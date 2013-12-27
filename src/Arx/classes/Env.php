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
        if(class_exists('Config', false)) {
            $config = \Config::get('env');
        } else {
            $config = include dirname(__DIR__).'/../config/env.php';
        }

        foreach($config as $key => $value){
            if(is_callable($value) && $value instanceof \Closure && $value()){
                    return $key;
            } elseif(is_string($value)) {

                if(preg_match($value, getenv('HTTP_HOST') )){
                    return $key;
                }
            }
        }
    }
}