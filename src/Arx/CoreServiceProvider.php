<?php namespace Arx;

use View,Config,Lang,Arx;

use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider {

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
        $this->package('arx/core');

        // Add namespace package so you can access to views, lang and config with arx::
        \View::addNamespace('arx', __DIR__.'/../views');
        \Lang::addNamespace('arx', __DIR__.'/../lang');
        \Config::addNamespace('arx', __DIR__.'/../config');

        Arx::ignite();

        require_once __DIR__.'/start/artisan.php';
        require_once __DIR__.'/start/global.php';
        require_once __DIR__.'/helpers.php';
        require_once __DIR__.'/filters.php';
        require_once __DIR__.'/routes.php';
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['command.arx.gen'] = $this->app->share(function()
        {
            return new GenCommand();
        });

        $this->commands('command.arx.gen');

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