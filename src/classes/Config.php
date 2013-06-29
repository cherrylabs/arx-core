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

    protected $aSettings = array();


    // --- Magic methods

    /**
     * Magic function __callStatic.
     *
     * @param string $sMehod The name of the method
     * @param mixed  $mArgs  Params
     *
     * @return mixed
     */
    public static function __callStatic($sMehod, $mArgs)
    {
        $config = static::getInstance();

        if (method_exists($config, $sMethod)) {
            return call_user_func_array(array($config, $sName), $mArgs);
        }

        return false;
    } // __callStatic


    // --- Public methods

    /**
     * Delete a setting.
     *
     * @param string $sName The name of the setting
     *
     * @return void
     */
    public function delete($sName)
    {
        Arrays::delete($this->aSettings, $sName);
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
     * Config::getInstance()->get('something.other');
     *
     * @todo Faire en sorte que si pas trouvé dans les config user (property), il tente de chopper la config par défault (default.property)
     */
    public function get($sNeedle = null, $mDefault = null)
    {
        if (is_null($sNeedle) && is_null($mDefault)) {
            $mDefault = $this->aSettings;
        }

        return Arrays::get($this->aSettings, $sNeedle, Arrays::get($this->aSettings, 'defaults.'.$sNeedle, $mDefault));  // restart working here !!! :-)
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
     * Config::getInstance()->load('paths.adapters', 'defaults'); // dot-notated query url in configuration paths
     * Config::getInstance()->load('some/path/to/your/configuration/file.php');
     * Config::getInstance()->load('some/path/to/your/configuration/folder/');
     */
    public function load($mPath, $sNamespace = null)
    {
        if (is_array($mPath) && count($mPath) > 0) {
            $aFiles = realpath($mPath);
        } elseif (strpos($mPath, '.') > 0 && !is_null(Arrays::get($this->aSettings, $mPath))) {
            $tmp = Arrays::get($this->aSettings, $mPath);
            $aFiles = glob(substr($tmp, -1) === '/' ? $tmp.'*' : $tmp);
        } else {
            $aFiles = glob(substr($mPath, -1) === '/' ? $mPath.'*' : $mPath);
        }

        foreach ($aFiles as $sFilePath) {
            $pathinfo = pathinfo($sFilePath);
            $key = !is_null($sNamespace) ? $sNamespace.'.'.$pathinfo['filename'] : $pathinfo['filename'];

            if (!is_int(array_search($sFilePath, $aFiles))) {
                $key = array_search($sFilePath, $aFiles);
            }

            if (!is_null(Arrays::get($this->aSettings, $key))) {
                $this->set($key, Arrays::merge($this->get($key), include $sFilePath));
            } else {
                $this->set($key, include $sFilePath);
            }
        }

        return $this;
    } // load


    /**
     * Request a particular config.
     *
     * @param string $sNeedle The config name requested
     *
     * @return bool           True if the config exist, false instead
     */
    public function needs($sNeedle) {} // needs


    /**
     * Set value in $_settings
     *
     * @param string $sName  Array of new value or name
     * @param mixed  $mValue Value for name
     *
     * @return void
     *
     * @example
     * Config::getInstance()->set(array('defaults.somehing' => 'something'));
     * Config::getInstance()->set('defaults.something', 'something');
     */
    public function set($sName, $mValue = null)
    {
        if (is_array($sName)) {
            foreach ($sName as $key => $value) {
                Arrays::set($this->aSettings, $key, $value);
            }
        } else {
            Arrays::set($this->aSettings, $sName, $mValue);
        }

        return $this;
    } // set

} // class::Config
