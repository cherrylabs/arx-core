<?php namespace Arx;

require_once __DIR__ . '/core.php';
require_once __DIR__ . '/traits/ServiceProviderTrait.php';

use Arx\classes\view\engines\CompilerEngine;
use Arx;

use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider {

    use ServiceProviderTrait;

    /**
     * The providers autoloaded by this module
     *
     * @var array
     */
    public $providers = [
        'Collective\Html\HtmlServiceProvider'
    ];

    /**
     * The facades that will be autoloaded
     *
     * @var array
     */
    public $facades = [
        # Missing Facades helpers
        'Controller' => 'Illuminate\Routing\Controller',
        'HTML' => 'Collective\Html\HtmlFacade',
        'Form' => 'Collective\Html\FormFacade',
        'Input' => '\Illuminate\Support\Facades\Input',
        # Arx
        'Asset' => 'Arx\classes\Asset',
        'Shortcode' => 'Arx\facades\Shortcode',
        'Arr' => 'Arx\classes\Arr',
        'Hook' => 'Arx\classes\Hook',
        'Dummy' => 'Arx\classes\Dummy',
        'Utils' => 'Arx\classes\Utils',
    ];

    public $commands = [
        'make:js' => 'Arx\\JsCommand',
        'make:angular' => 'Arx\\AngularCommand',
        'arx:publish-assets' => 'Arx\\PublishCommand',
    ];

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        Arx::ignite();

        $this->loadViewsFrom(__DIR__.'/../views', 'arx');
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'arx');
        require_once __DIR__.'/helpers.php';
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;

        // Add Custom Tpl extension (.tpl)
        $this->app['view']->addExtension('tpl.php',
            'tpl',
            function() use ($app) {
                $cache = $app['path.storage'].'/framework/views';

                $compiler = new Arx\classes\view\engines\tpl\TplCompiler($app['files'], $cache);

                return new CompilerEngine($compiler);
            }
        );

        // Add Shortcode handler
        $this->app['shortcode'] = $this->app->share(function($app)
        {
            return new Arx\classes\Shortcode();
        });

        $this->app->singleton('notify', function () {
            return $this->app->make('Arx\classes\Notify');
        });

        $this->registerFacades();
        $this->registerProviders();
        $this->registerCommands();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array(
            'shortcode',
            'notify'
        );
    }

}