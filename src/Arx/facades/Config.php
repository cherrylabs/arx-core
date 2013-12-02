<?php namespace Arx\facades;

use Arx\classes\Facade;

/**
 * Config Facade of Laravel
 *
 * Add some functionnalities like resolving config issue when your package is in the workbench
 *
 * @package Arx\facades
 */
class Config extends Facade{

    /**
     * Get the specified configuration value.
     *
     * @param string  $key
     * @param mixed   $default
     * @return mixed
     * @static
     */
    public static function get($key, $default = null)
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