<?php namespace Arx;

/**
 * Class HashServiceProvider
 *
 * For downgrading Laravel compatibility to 5.3.2
 *
 * @package Arx
 */
class HashServiceProvider extends \Illuminate\Support\ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->app['hash'] = $this->app->share(function () {
            return new \Arx\classes\Hash();
        });

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return array('hash');
    }

}