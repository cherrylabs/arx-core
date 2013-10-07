<?php namespace Arx;

use View,Config,Lang,Arx;

use Arx\classes\Utils as u;
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

        \View::addNamespace('arx', Arx::path('views'));
        \Lang::addNamespace('arx', Arx::path('lang'));
        \Config::addNamespace('arx', Arx::path('config'));

        u::alias('predie', '\Arx\classes\Utils::predie');

        u::alias('k', '\Arx\classes\Utils::k');

        u::alias('lg', '\Lang::get');

        require_once 'filters.php';
        require_once 'routes.php';


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