<?php namespace Arx\classes;

use Closure;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Router;
use Illuminate\Config\FileLoader;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Events\EventServiceProvider;
use Illuminate\Foundation\ProviderRepository;
use Illuminate\Routing\RoutingServiceProvider;
use Illuminate\Exception\ExceptionServiceProvider;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Contracts\ResponsePreparerInterface;
use Symfony\Component\Debug\Exception\FatalErrorException;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirect;
use Exception;
use Arx\classes\Config;


/**
 * App extends the Laravel Application and add some extra functions
 *
 * @category Core
 * @package  Arx
 * @author   Daniel Sum <daniel@cherrypulp.com>
 * @author   Stéphan Zych <stephan@cherrypulp.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @link     http://arx.xxx/doc/App
 */
class App extends Application
{

    // --- Constants

    const VERSION = '1.0';

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


    public function __construct($request = null)
    {
        $this['request'] = $this->createRequest($request);

        // The exception handler class takes care of determining which of the bound
        // exception handler Closures should be called for a given exception and
        // gets the response from them. We'll bind it here to allow overrides.
        $this->register(new ExceptionServiceProvider($this));

        $this->register(new RoutingServiceProvider($this));

        $this->register(new EventServiceProvider($this));
    }


    /**
     * Bootstrap define how the app should include his configuration
     *
     * By default, it includes file from ../bootstraps folder
     *
     * @see ../bootstraps/default.php
     *
     * @param string $file
     *
     * @throws \Whoops\Example\Exception
     */
    public function bootstrap($config = null, $file = 'default.php'){
        global $app;

        $app = $this;

        $this['arxconfig'] = Config::load(__DIR__.'/../config/');

        if(!$config){
            $this['arxconfig'] = Config::load($config);
        }

        if(is_file($file)){
            require_once $file;
        } elseif(is_file($file = __DIR__.'/../bootstrap/'.$file)){
            require_once $file;
        } else{
            Throw new Exception('Whoops, there is nothing to boot');
        }
    }


    /**
     * Autoload an undefined class
     *
     * @param       $className
     * @param array $aParam
     *
     * @return void
     */
    static function autoload($className, $aParam = array())
    {
        $instance = self::getInstance();

        $aAutoload = Config::get('autoload');

        $className = ltrim($className, '\\');
        $fileName = '';
        $namespace = '';
        $vendorName = '';
        $packageName = '';
        $routeName = '';
        $composerName = '';

        if ($lastNsPos = strrpos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;

            $aExplode = explode('\\', $namespace);
            $iExplode = count($aExplode);

            if($iExplode === 1){
                $packageName = $aExplode[0];
            } elseif($iExplode === 2){
                list($vendorName, $packageName) = $aExplode;
                $composerName = $vendorName.'/'.$packageName;
            } elseif($iExplode >= 3){
                $vendorName = array_shift($aExplode);
                $packageName = array_shift($aExplode);
                $composerName = $vendorName.'/'.$packageName;
                $routeName = implode('/', $aExplode);
            }
        }
        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

        $aNamespaces = Composer::getNamespaces();


        if (in_array($namespace, array_keys($aNamespaces))) {
            dd($fileName, $namespace, $className, $fileName, $vendorName, $packageName, $routeName);
        } elseif(in_array($composerName, array_keys($aNamespaces))){

            $paths = $aNamespaces[$composerName];

            foreach($paths as $path){
                if(is_file($fileName = $path.'/'.$fileName)){
                    include $fileName;
                }
            }
        }

        if(is_file($fileName = Config::get('paths.workbench') . DS . strtolower($composerName) .DS. 'src' . DS . $fileName)){
            include $fileName;
        } elseif(is_file($fileName = Config::get('paths.workbench') . DS . $fileName)){
            include $fileName;
        }

        if (is_array($aAutoload) and array_key_exists($className, $aAutoload) and is_file($aAutoload[$className])) {
            include $aAutoload[$className];
        }
    }

    /**
     * Get the instance of the App
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
