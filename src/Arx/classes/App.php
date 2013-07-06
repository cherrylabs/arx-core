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
class App extends Container
{

    // --- Constants

    const VERSION = '1.0';
    const CODENAME = 'Lupanar';


    // --- Private members

    protected $_cache = null;
    protected $_config = null;
    protected $_debug = null;
    protected $_orm = null;
    protected $_router = null;
    protected $_view = null;


    // --- Constructor

    /**
     * Magic constructor by default load default config.
     *
     * @param mixed $mConfig Path, array of paths or array of params
     */
    public function __construct($mConfig = null)
    {
        $this->_config = Config::instance();

        $this->_config->load(__DIR__ . '/../config/', 'defaults');

        if (!is_null($mConfig)) {
            if (is_array($mConfig)) {
                $this->_config->set($mConfig);
            } else {
                $this->_config->load($mConfig);
            }
        }


        // Settings Aliases
        $aliases = $this->_config->get('aliases');

        foreach ($aliases['classes'] as $aliasName => $class) {
            if (!class_exists($aliasName)) {
                class_alias($class, $aliasName);
            }
        }

        foreach ($aliases['functions'] as $aliasName => $callback) {
            if (!function_exists($aliasName)) {

                Utils::alias($aliasName, $callback);
            }
        }

        // Settings System
        $system = $this->_config->get('system');

        foreach ($system as $type => $class) {
            $this->{'_' . $type} = new \ReflectionClass($class);
        }

    } // __construct


    // --- Magic methods

    public function __call($sName, $aArgs)
    {

    } // __call


    public static function __callStatic($sName, $aArgs)
    {

    } // __callStatic


    public function __get($sName)
    {
        if(isset($this->{'_'.$sName})){
            return $this->{'_'.$sName};
        }
    } // __get


    public function __set($sName, $mValue)
    {

    } // __set

    public function get()
    {
        call_user_func_array(array($this->_route, 'get'), func_get_args());
    }

    static function load()
    {

        $instance = self::getInstance();

        $className = ltrim($className, '\\');
        $fileName = '';
        $namespace = '';

        if ($lastNsPos = strrpos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

        require $fileName;

    } // load

    static function autoload($className, $aParam = array())
    {
        $aAutoload = Config::get('autoload');

        $className = ltrim($className, '\\');
        $fileName  = '';
        $namespace = '';
        if ($lastNsPos = strrpos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

        $aNamespaces = Composer::getNamespaces();

        if (is_array($aAutoload) and array_key_exists($className, $aAutoload) and is_file($aAutoload[$className])) {
            include $aAutoload[$className];
        } else {

        }

        if($className != 'u'){

            $aNamespaces = Composer::getNamespaces();

        }
    }


} // class::App
