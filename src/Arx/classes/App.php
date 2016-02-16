<?php namespace Arx\classes;

use \Illuminate\Foundation\Application as ParentClass;
use Exception;


/**
 * Class App Override Laravel App class
 *
 * App is used mainly for some autocompletion task needed by core.php
 *
 * @category Core
 * @package  Arx
 * @author   Daniel Sum <daniel@cherrypulp.com>
 * @author   Stéphan Zych <stephan@cherrypulp.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @link     http://www.arx.io/arx/core/src/Arx/classes
 */
class App extends ParentClass
{
    // --- Constants
    const VERSION = '5.1.0';

    const CODENAME = 'Lupa';

    // --- Protected value

    /**
     * Indicates if the application has "booted".
     *
     * @var bool
     */
    protected $booted = false;

    /**
     * The array of booting callbacks.
     *
     * @var array
     */
    protected $bootingCallbacks = array();

    /**
     * The array of booted callbacks.
     *
     * @var array
     */
    protected $bootedCallbacks = array();

    /**
     * The array of shutdown callbacks.
     *
     * @var array
     */
    protected $shutdownCallbacks = array();

    /**
     * All of the registered service providers.
     *
     * @var array
     */
    protected $serviceProviders = array();

    /**
     * The names of the loaded service providers.
     *
     * @var array
     */
    protected $loadedProviders = array();

    /**
     * The deferred services and their providers.
     *
     * @var array
     */
    protected $deferredServices = array();

    // --- Constructor

    protected static $_aInstances = array();


    /**
     * Bootstrap define how the app should include his configuration. By default, it includes file from ../bootstraps folder as Laravel do
     *
     * You can also override some arx configs too for a special case
     *
     * @see ../bootstraps/default.php
     * @see ../config/
     *
     * @param string $file
     *
     * @param string $config
     * @throws Exception
     */
    public function bootstrap($file = 'start.php', $config = null){

        global $app;

        $app = $this;

        if($config){
            $this['arxconfig'] = Config::load($config);
        } else {
            // Inject special ARX Config to APP
            $this['arxconfig'] = Config::load(__DIR__.'/../config/');
        }

        if(is_file($file)){
            require_once $file;
        } elseif(is_file($file = __DIR__.'/../../bootstrap/'.$file)){
            require_once $file;
        } else{
            Throw new Exception('Whoops, there is no file to boot...');
        }
    }

    /**
     * Get the instance of the App in the Singleton way
     *
     * Used when is not a laravel structure
     *
     * @return mixed
     */
    public static function getInstance(){
        $sClass = get_called_class();

        if (!isset(self::$_aInstances[$sClass])) {
            self::$_aInstances[$sClass] = new $sClass;
        }

        return self::$_aInstances[$sClass];
    }

} // class::App
