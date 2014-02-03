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
 * Class App Override Laravel App class
 *
 * App extends the Laravel Application and add some extra functions that lacks in Laravel
 *
 * @category Core
 * @package  Arx
 * @author   Daniel Sum <daniel@cherrypulp.com>
 * @author   Stéphan Zych <stephan@cherrypulp.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @link     http://www.arx.io/arx/core/src/Arx/classes
 */
class App extends \Illuminate\Foundation\Application
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


    /**
     * Bootstrap define how the app should include his configuration. By default, it includes file from ../bootstraps folder as Laravel do
     *
     * You can also override some arx configs too for a special case
     *
     * @see ../bootstraps/default.php
     * @see ../config/
     *
     * @param string $config
     * @param string $file
     *
     * @throws \Whoops\Example\Exception
     */
    public function bootstrap($config = null, $file = 'default.php'){
        global $app;

        $app = $this;

        // Inject special ARX Config to APP
        $this['arxconfig'] = Config::load(__DIR__.'/../config/');

        if($config){
            $this['arxconfig'] = Config::load($config);
        }

        if(is_file($file)){
            require_once $file;
        } elseif(is_file($file = __DIR__.'/../../bootstrap/'.$file)){
            require_once $file;
        } else{
            Throw new Exception('Whoops, there is no file boot');
        }
    }


    /**
     * Autoload an undefined class and add more resolving case for the workbench environment
     *
     * Example : if in your workbench package you call a class with xxxController, xxxModel, xxxClass at the end, it
     * will try to resolve the class by searching inside the controllers folder
     *
     * /!\ you must always add a classmap in your composer.json file !
     *
     * @param       $className
     * @param array $aParam
     *
     * @return void
     *
     * @todo clean this function
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
        $supposedPath = ''; # Supposed path if class have a autoload structure in workbench

        if ($lastNsPos = strrpos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;

            $aExplode = explode('\\', $namespace);
            $iExplode = count($aExplode);

            if($iExplode === 1){
                $composerName = $packageName = $aExplode[0];
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

        } elseif(in_array($composerName, array_keys($aNamespaces))){

            $paths = $aNamespaces[$composerName];

            foreach($paths as $path){
                if(is_file($fileName = $path.'/'.$fileName)){
                    include $fileName;
                }
            }
        }

        if(isset($aNamespaces[$composerName]) && !empty($aNamespaces[$composerName])){

            if(preg_match('/Controller$/', $className)){

                $supposedPath = end($aNamespaces[$composerName]) . DS. str_replace('\\', DS, $namespace) . DS.  'controllers' . DS . $className . '.php';

            }

            if(preg_match('/Model$/', $className)){

                $supposedPath = end($aNamespaces[$composerName]) . DS . str_replace('\\', DS, $namespace) . DS. 'models' . DS . $className . '.php';
            }

            if(preg_match('/Class$/', $className)){
                $supposedPath = end($aNamespaces[$composerName]) . DS . str_replace('\\', DS, $namespace) . DS. 'classes' . DS . $className . '.php';
            }

        }

        try {
            if(is_file($fileName = Config::get('paths.workbench') . DS . strtolower($composerName) .DS. 'src' . DS . $fileName)){
                include $fileName;
            } elseif(is_file($fileName = Config::get('paths.workbench') . DS . $fileName)){
                include $fileName;
            } elseif (is_array($aAutoload) and array_key_exists($className, $aAutoload) and is_file($aAutoload[$className])) {
                include $aAutoload[$className];
            } elseif(is_file($supposedPath) ) {
                include $supposedPath;
            }
        } catch (Exception $e) {
            trigger_error($e);
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

    /**
     * resolve a conflict with the Laravel method
     *
     * @return null|SymfonyRedirect|void
     */
    public function redirectIfTrailingSlash()
    {
        if ($this->runningInConsole()) {
            return;
        }
        $path = $this['request']->getPathInfo();
        if ($path != '/' and ends_with($path, '/') and !ends_with($path, '//')) {
            with(new SymfonyRedirect($this['request']->fullUrl(), 301))->send();
            die;
        }
    }

} // class::App
