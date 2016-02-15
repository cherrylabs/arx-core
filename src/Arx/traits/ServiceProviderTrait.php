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
     * Register commands helper
     */
    public function registerCommands(){

        foreach($this->commands as $name => $class){

            $dotName = str_replace(':', '.', $name);

            $this->app['command.'.$dotName] = $this->app->share(function() use ($class)
            {
                $commandClassName = $class;
                return new $commandClassName();
            });

            $this->commands('command.'.$dotName);
        }
    }

    /**
     * Register providers helpers
     */
    public function registerProviders()
    {
        foreach ($this->providers as $provider) {
            $this->app->register($provider);
        }
    }

    /**
     * Register facades helpers
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