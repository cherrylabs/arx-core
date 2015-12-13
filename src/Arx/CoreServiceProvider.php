<?php namespace Arx;

require_once __DIR__ . '/core.php';

use Arx\classes\view\engines\CompilerEngine;
use View,Config,Lang,Arx;

use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider {

    use ServiceProviderTrait;

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Define the commands to load from commands folder
     * @var array
     */
    protected $commands = [
        'angular',
        'js'
    ];

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

        require_once __DIR__.'/start/artisan.php';
        require_once __DIR__.'/start/global.php';
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


        /**
         * Autoload commands
         */
        foreach($this->commands as $command){

            $this->app['command.arx.'.$command] = $this->app->share(function() use ($command)
            {
                $commandClassName = 'Arx\\'.ucfirst($command) . 'Command';
                return new $commandClassName();
            });

            $this->commands('command.arx.'.$command);
        }

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
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array(
            'shortcode'
        );
    }

}