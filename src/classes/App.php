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
        $aFiles = glob(__DIR__.'/utils/*');

        foreach ($aFiles as $sFilePath) {
            include_once $sFilePath;
        }

        Config::load(__DIR__.'/../config/*', 'default');

        $this->_config = Config::getInstance();

        if (!is_null($mConfig)) {
            $system = Config::get('system');

            foreach ($system as $type => $class) {
                $path = Config::get('paths.adapters');

                if (end(explode(DS, $path)) !== '') {
                    $path .= DS;
                }

                Config::load($path.$class.'.php');

                $className = '\\App\\classes\\'.$type;

                if (class_exists($className)) {
                    $this->{'_'.$type} = new $className();
                }
            }
        }

        // ...

    } // __construct


    // --- Magic methods

    public function __call($sName, $aArgs) {} // __call


    public static function __callStatic($sName, $aArgs) {} // __callStatic


    public function __get($sName) {} // __get


    public function __set($sName, $mValue) {} // __set


} // class::App
