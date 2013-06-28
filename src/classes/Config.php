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
class Config extends Singleton
{
    // --- Protected members

    protected static $aSettings = array();


    // --- Public methods

    /**
     * Request a particular config.
     *
     * @param string $sNeedle The config name requested
     *
     * @return bool            True if the config exist, false instead
     */
    public static function needs($sNeedle) {} // get


    /**
     * Get value from $_settings
     *
     * @param string $sNeedle  The (dot-notated) name
     * @param mixed  $mDefault A default value if necessary
     *
     * @return mixed           The value of the setting or the entire settings array
     *
     * @example
     * Config::get();
     */
    public static function get($sNeedle = null, $mDefault = null)
    {
<<<<<<< HEAD
        if (!is_null(Arrays::get(self::$aSettings, $sNeedle, $mDefault))) {
            $mDefault = Arrays::get(self::$aSettings, $sNeedle, $mDefault);
=======
        die('oki');
        if (!is_null(Arrays::get(self::$settings, $sName, $mDefault))) {
            $mDefault = Arrays::get(self::$settings, $sName, $mDefault);
>>>>>>> 743f67e3ef01110e7c5d94e40c05359cf4aaae1f
        }

        if (is_null($sNeedle)) {
            $mDefault = self::$aSettings;
        }

        return $mDefault;
    } // get


    /**
     * Load single or multiple file configuration.
     *
     * @param string $mPath      Array of path or string
     * @param string $sNamespace String used as reference (ex. Config::get('namespace.paths.classes'))
     *
     * @return void
     *
     * @example
     * Config::load('paths.adapters', 'defaults'); // dot-notated query url in configuration paths
     * Config::load('some/path/to/your/configuration/file.php');
     * Config::load('some/path/to/your/configuration/folder/');
     */
    public static function load($mPath, $sNamespace = null)
    {
        if (is_array($mPath) && count($mPath) > 0) {
            $aFiles = $mPath;
        } elseif (strpos($mPath, '.') > 0 && !is_null(Arrays::get(self::$aSettings, $mPath))) {
            $tmp = Arrays::get(self::$aSettings, $mPath);
            $aFiles = glob(substr($tmp, -1) === '/' ? $tmp.'*' : $tmp);
        } else {
            $aFiles = glob(substr($mPaths, -1) === '/' ? $mPath.'*' : $mPath);
        }

        foreach ($sNamespace as $sFilePath) {
            $pathinfo = pathinfo($sFilePath);
            $key = !is_null($sNamespace) ? $sNamespace.'.'.$pathinfo['filename'] : $pathinfo['filename'];

            if (!is_null(self::get($key))) {
                self::set($key, Arrays::merge(self::get($key), include $sFilePath));
            } else {
                self::set($key, include $sFilePath);
            }
        }
    } // load


    /**
     * Set value in $_settings
     *
     * @param string $sName  Array of new value or name
     * @param mixed  $mValue Value for name
     *
     * @return void
     *
     * @example
     * Config::set(array('defaults.somehing' => 'something'));
     * Config::set('defaults.something', 'something');
     */
    public static function set($sName, $mValue = null)
    {
        if (is_array($sName)) {
            foreach ($sName as $key => $value) {
                Arrays::set(self::$aSettings, $key, $value);
            }
        } else {
            Arrays::set(self::$aSettings, $sName, $mValue);
        }
    } // set

} // class::Config




// <?php
// /**
//  * MonkeyMonk/Neuron
//  * PHP File - /config/config.php
//  */

// namespace Neuron;


// class Config extends Tools\Singleton {

//     // --- Public methods

//     /**
//      * Override or add some configuration in case of single file for multiple configuration.
//      *
//      * @param  string $sFile The file path
//      *
//      * @return void
//      */
//     public static function apply($sFile) {
//         $aSettings = include $sFile;

//         foreach ($aSettings as $key => $value) {
//             if (!is_null(static::get($key))) {
//                 if (is_array(static::get($key))) {
//                     static::set($key, Utils\UtilsArrays::merge(static::get($key), $value));
//                 } else {
//                     static::set($key, $value);
//                 }
//             } else {
//                 static::set($key, $value);
//             }
//         }
//     } // apply

//     public static function delete($sName) {
//         if (isset(static::getInstance()->_settings[$sName])) {
//             unset(static::getInstance()->_settings[$sName]);
//         }
//     } // delete

//     public static function get($sName = null, $mDefault = null) {
//         if (!is_null(Utils\UtilsArrays::get(static::getInstance()->_settings, $sName, $mDefault))) {
//             $mDefault = Utils\UtilsArrays::get(static::getInstance()->_settings, $sName, $mDefault);
//         }

//         if (is_null($sName) && is_null($mDefault)) {
//             $mDefault = static::getInstance()->_settings;
//         }

//         return $mDefault;
//     } // get

//     *
//      * Load configuration from file. If the given array has key, it will be used to override previously loaded configuration.
//      *
//      * @param  mixed  $mPaths File path or array of file path or dot-notated reference
//      *
//      * @return void
//      *
//      * @example
//      * Config::load('paths.adapters'); // dot-notated query url in configuration paths
//      * Config::load('some/path/to/your/configuration/file.php');
//      * Config::load('some/path/to/your/configuration/folder/*');

//     public static function load($mPaths) {
//         if (is_array($mPaths) && count($mPaths)) {
//             $aFiles = $mPaths;
//         } elseif (strpos($mPaths, '.') > 0 && !is_null(Utils\UtilsArrays::get(static::getInstance()->_settings, $mPaths))) {
//             $aFiles = glob(Utils\UtilsArrays::get(static::getInstance()->_settings, $mPaths).'*');
//         } else {
//             $aFiles = glob($mPaths);
//         }

//         foreach ($aFiles as $sFilePath) {
//             $pathinfo = pathinfo($sFilePath);
//             $key = $pathinfo['filename'];

//             if (!is_int(array_search($sFilePath, $aFiles))) {
//                 $key = array_search($sFilePath, $aFiles);
//             }

//             if (!is_null(static::get($key))) {
//                 static::set($key, Utils\UtilsArrays::merge(static::get($key), include $sFilePath));
//             } else {
//                 static::set($key, include $sFilePath);
//             }
//         }
//     } // load

//     public static function set($sName, $mValue) {
//         static::getInstance()->_settings[$sName] = $mValue;
//     } // set


//     // --- Protected members

//     protected $_settings = array();

// } // class::Config
