<?php namespace Arx\classes;

use Closure;

/**
 * Class Config used in Arx
 *
 * @package Arx\classes
 */
class Config extends Container
{
    // --- Protected members

    public static $aSettings = array();
    public static $env;
    public static $envLevel;
    public static $loadedPaths;
    protected static $_aInstances = array();


    // --- Magic methods


    // --- Public methods

    /**
     * Delete a setting.
     *
     * @param string $sName The name of the setting
     *
     * @return bool
     */
    public static function delete($sName)
    {
        return Arr::delete(static::$aSettings, $sName);
    } // delete


    /**
     * Detect environment
     *
     * By default check
     *
     * @return string env
     */
    public static function detectEnvironment($request = null)
    {
        if (!empty(static::$env)) {
            return static::$env;
        }

        $rules = self::get('env');

        $request = $request ? $request : Request::createFromGlobals();

        $host = $request->getHost();

        foreach ($rules as $env => $rule) {
            if (is_callable($rule)) {
                static::$env = $env;
            } elseif (preg_match($rule, $host)) {
                static::$env = $env;
                break;
            }
        }

        static::loadEnvironment(static::$env);

        return static::$env;
    }

    /**
     * Load an environment defined or not
     *
     * @param null $env
     * @return void
     */
    public static function loadEnvironment($env = null)
    {
        $env = $env ? $env : static::$env;

        foreach((array) static::$loadedPaths as $path){
            if(is_dir($path.DS.$env)){
                self::load($path.DS.$env);
            }
        }
    }

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

        return Arr::get(static::$aSettings, $sNeedle, Arr::get(static::$aSettings, 'defaults.' . $sNeedle, $mDefault));
    } // get

    public static function getInstance()
    {
        $sClass = get_called_class();

        if (!isset(self::$_aInstances[$sClass])) {
            self::$_aInstances[$sClass] = new $sClass;
        }

        return self::$_aInstances[$sClass];
    }


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
        # Check if $mPath is an array of path
        if (is_array($mPath) && !empty($mPath)) {
            $aFiles = $mPath;
        } elseif (strpos($mPath, '.') > 0 && !is_null(Arr::get(static::$aSettings, $mPath))) {
            $tmp = Arr::get(static::$aSettings, $mPath);
            $aFiles = glob(substr($tmp, -1) === '/' ? $tmp . '*.php' : $tmp);
        } else {
            $aFiles = glob(substr($mPath, -1) === '/' ? $mPath . '*.php' : $mPath);
        }

        foreach ($aFiles as $sFilePath) {

            $pathinfo = pathinfo($sFilePath);
            $key = !is_null($sNamespace) ? $sNamespace . '.' . $pathinfo['filename'] : $pathinfo['filename'];

            if (!is_int(array_search($sFilePath, $aFiles))) {
                $key = array_search($sFilePath, $aFiles);
            }

            if (!is_null(Arr::get(static::$aSettings, $key))) {
                static::set($key, Arr::merge(static::get($key), include $sFilePath));
            } elseif (is_file($sFilePath)) {
                static::set($key, include $sFilePath);
            }
        }

        return static::getInstance();
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
    public static function needs($sNeedle, $sCallback = null, $aArgs = null)
    {
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

        return static::getInstance();
    } // set

    public static function values()
    {
        return static::$aSettings;
    }

    /**
     * Get the value at a given offset.
     *
     * @param  string $key
     *
     * @return mixed
     */
    public function offsetGet($key)
    {
        $value = self::get($key);

        if (!is_null($value)) {
            return $value;
        }

        return $this->make($key);
    }

    /**
     * Set the value at a given offset.
     *
     * @param  string $key
     * @param  mixed  $value
     *
     * @return void
     */
    public function offsetSet($key, $value)
    {
        // If the value is not a Closure, we will make it one. This simply gives
        // more "drop-in" replacement functionality for the Pimple which this
        // container's simplest functions are base modeled and built after.
        if (!$value instanceof Closure) {
            $value = function () use ($value) {
                return $value;
            };
        }

        $this->bind($key, $value);
    }

    /**
     * Unset the value at a given offset.
     *
     * @param  string $key
     *
     * @return void
     */
    public function offsetUnset($key)
    {
        unset($this->bindings[$key]);
    }

} // class::Config
