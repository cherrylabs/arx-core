<?php namespace Arx\classes;

/**
 * App
 *
 * @category Core
 * @package  Arx
 * @author   Daniel Sum <daniel@cherrypulp.com>
 * @author   Stéphan Zych <stephan@cherrypulp.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @link     http://arx.xxx/doc/App
 */
class App extends Singleton
{

    // --- Constants

    const VERSION = '1.0';
    const CODENAME = 'Lupa';


    // --- Private members

    private $_cache = null;
    private $_config = null;
    private $_debug = null;
    private $_orm = null;
    private $_route = null;
    private $_template = null;


    // --- Constructor

    /**
     * Magic constructor by default load default config.
     *
     * @param mixed $mConfig Path, array of paths or array of params
     */
    public function __construct($mConfig = null)
    {
        $this->_config = Config::getInstance();

        $this->_config->load(__DIR__.'/../config/', 'defaults');

        if (!is_null($mConfig)) {
            if (is_array($mConfig)) {
                $this->_config->set($mConfig);
            } else {
                $this->_config->load($mConfig);
            }
        }

        // Settings System
        $system = $this->_config->get('system');

        foreach ($system as $type => $class) {
            $path = $this->_config->get('paths.adapters');

            if (end(explode(DS, $path)) !== '') {
                $path .= DS;
            }

            $this->_config->load($path.$class.'.php');

            $className = '\\Arx\\classes\\'.$type;

            if (class_exists($className)) {
                $this->{'_'.$type} = new $className();
            }
        }

        // ...


        // Settings Aliases
        $aliases = $this->_config->get('defaults.aliases');

        foreach ($aliases['classes'] as $aliasName  => $class) {
            class_alias($class, $aliasName);
        }

        foreach ($aliases['functions'] as $aliasName => $callback) {
            Utils::alias($aliasName, $callback);
        }

    } // __construct


    // --- Magic methods

    public function __call($sName, $aArgs) {} // __call


    public static function __callStatic($sName, $aArgs) {} // __callStatic


    public function __get($sName) {} // __get


    public function __set($sName, $mValue) {} // __set


} // class::App
