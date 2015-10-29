<?php namespace Arx;

use Illuminate\Foundation\AliasLoader;

/**
 * Class ServiceProviderTrait
 *
 * Service provider trait helpers
 *
 */
trait ServiceProviderTrait {

    /**
     * The providers autoloaded by this module
     *
     * @var array
     */
    protected $providers = [

    ];

    /**
     * The facades that will be autoloaded
     *
     * @var array
     */
    protected $facades = [

    ];


    /**
     * Register the providers.
     */
    public function registerProviders()
    {
        foreach ($this->providers as $provider) {
            $this->app->register($provider);
        }
    }
    /**
     * Register the facades.
     */
    public function registerFacades()
    {
        AliasLoader::getInstance($this->facades);

        # Auto-register alias
        foreach ($this->facades as $alias => $name) {
            AliasLoader::getInstance()->alias($alias, $name);
        }
    }
}