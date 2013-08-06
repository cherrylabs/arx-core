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
        $this->package('Arx/Core');
        View::addNamespace('Arx', Arx::path('views'));
        Lang::addNamespace('Arx', Arx::path('lang'));
        Config::addNamespace('Arx', Arx::path('config'));

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

}