<?php namespace Arx\interfaces;

use Arx\classes\Facade;

class Config extends Facade{

    /**
     * Accessing A Configuration Value
     *
     * @param $value
     * @param $defaultValue
     * @return mixed
     */
    public static function get($value, $defaultValue)
    {
        return self::resolve();
    }

    /**
     * Setting a Configuration Value
     *
     * @param $name
     * @param $value
     * @return Object Config
     */
    public static function set($name, $value){
        return self::resolve();
    }


    /**
     * Load a configuration in a file or directory if keyname is set will assign to that key
     *
     * <code>
     *  <?php
     *      Config::load('/app/config/facebook.php');
     *      Config::get('facebook') //will return returned array in /app/config/facebook.php
     *
     *      Config::load('/app/config/googleapps', 'google');
     *      Config::get('google.map') //will return returned array in /app/config/googleapps/map.php'
     *  ?>
     * </code>
     *
     * @param $fileOrDirectory
     * @param null $keyName
     * @return Object Config
     */
    public static function load($fileOrDirectory, $keyName = null){
        return self::resolve();
    }

    /**
     * Get the registered name of the component instanciate by the app
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'config'; }
}