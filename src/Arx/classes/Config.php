<?php namespace Arx\classes;

/**
 * Config
 *
 * @category Configuration
 * @package  Arx
 * @author   Daniel Sum <daniel@cherrypulp.com>
 * @author   Stéphan Zych <stephan@cherrypulp.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @link     http://arx.xxx/doc/Config
 */

include_once 'Container.php';

class Config extends Container
{
    // --- Private memebers

    private static $_instance;


    // --- Protected members

    protected static $aSettings = array();


    // --- Magic methods


    // --- Public methods

    /**
     * Delete a setting.
     *
     * @param string $sName The name of the setting
     *
     * @return void
     */
    public static function delete($sName)
    {
        Arr::delete(static::$aSettings, $sName);
    } // delete


    /**
     * Get value from $_settings
     *
     * @param string $sNeedle  The (dot-notated) name
     * @param mixed  $mDefault A default value if necessary
     *
     * @return mixed           The value of the setting or the entire settings array
     *
     * @example
     * Config::instance()->get('something.other');
     */
    public static function get($sNeedle = null, $mDefault = null)
    {
        if (is_null($sNeedle) && is_null($mDefault)) {
            return static::$aSettings;
        }

        return Arr::get(static::$aSettings, $sNeedle, Arr::get(static::$aSettings, 'defaults.'.$sNeedle, $mDefault));
    } // get

    public static function instance(){
        if (is_null(self::$_instance)) {
            self::$_instance = new Config();
        }

        return self::$_instance;
    } // instance


    /**
     * Load single or multiple file configuration.
     *
     * @param string $mPath      Array of path or string
     * @param string $sNamespace String used as reference (ex. Config::get('namespace.paths.classes'))
     *
     * @return object
     *
     * @example
     * Config::instance()->load('paths.adapters', 'defaults'); // dot-notated query url in configuration paths
     * Config::instance()->load('some/path/to/your/configuration/file.php');
     * Config::instance()->load('some/path/to/your/configuration/folder/');
     */
    public static function load($mPath, $sNamespace = null)
    {
        if (is_array($mPath) && count($mPath) > 0) {
            $aFiles = realpath($mPath);
        } elseif (strpos($mPath, '.') > 0 && !is_null(Arr::get(static::$aSettings, $mPath))) {
            $tmp = Arr::get(static::$aSettings, $mPath);
            $aFiles = glob(substr($tmp, -1) === '/' ? $tmp.'*.php' : $tmp);
        } else {
            $aFiles = glob(substr($mPath, -1) === '/' ? $mPath.'*.php' : $mPath);
        }

        foreach ($aFiles as $sFilePath) {
            $pathinfo = pathinfo($sFilePath);
            $key = !is_null($sNamespace) ? $sNamespace.'.'.$pathinfo['filename'] : $pathinfo['filename'];

            if (!is_int(array_search($sFilePath, $aFiles))) {
                $key = array_search($sFilePath, $aFiles);
            }

            if (!is_null(Arr::get(static::$aSettings, $key))) {
                static::set($key, Arr::merge(static::get($key), include $sFilePath));
            } else {
                static::set($key, include $sFilePath);
            }
        }

        return static::instance();
    } // load


    /**
     * Request a particular config.
     *
     * @param string $sNeedle   The config name requested
     * @param string $sCallback The callback if not find
     * @param array  $aArgs     The args of the callback
     *
     * @return bool             True if the config exist, false instead
     */
    public static function needs($sNeedle, $sCallback = null, $aArgs = null) {
        if (!is_null(static::get($sNeedle))) {
            return true;
        } elseif (!is_null($sCallback)) {
            if (is_array($aArgs)) {
                return call_user_func_array($sCallback, $aArgs);
            }

            return call_user_func($sCallback);
        }

        return false;
    } // needs


    /**
     * Set value in $_settings
     *
     * @param string $sName  Array of new value or name
     * @param mixed  $mValue Value for name
     *
     * @return object
     *
     * @example
     * Config::instance()->set(array('defaults.somehing' => 'something'));
     * Config::instance()->set('defaults.something', 'something');
     */
    public static function set($sName, $mValue = null)
    {
        if (is_array($sName)) {
            foreach ($sName as $key => $value) {
                Arr::set(static::$aSettings, $key, $value);
            }
        } else {
            Arr::set(static::$aSettings, $sName, $mValue);
        }

        return static::instance();
    } // set

} // class::Config
