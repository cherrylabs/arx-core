<?php namespace Arx\classes;

use Illuminate\View\ViewServiceProvider;
use Arx\classes\view\FileViewFinder;
use Arx\classes\view\engines\CompilerEngine;
use Arx\classes\view\engines\PhpEngine;
use Illuminate\View\Compilers\BladeCompiler;
use Arx\classes\view\engines\tpl\TplCompiler;

/**
 * Class View
 *
 * Add the tpl.php extension handler
 *
 * @package Arx\classes
 */
class View extends ViewServiceProvider {

    /**
     * Register the PHP engine implementation.
     *
     * @param  \Illuminate\View\Engines\EngineResolver  $resolver
     * @return void
     */
    public function registerPhpEngine($resolver)
    {
        $resolver->register('php', function() { return new PhpEngine; });
    }

    /**
     * Register the Tpl engine implementation.
     *
     * @param  \Illuminate\View\Engines\EngineResolver  $resolver
     * @return void
     */
    public function registerTplEngine($resolver)
    {
        $app = $this->app;

        $resolver->register('tpl', function() use ($app)
        {
            $cache = $app['path.storage'].'/views';

            // The Compiler engine requires an instance of the CompilerInterface, which in
            // this case will be the Blade compiler, so we'll first create the compiler
            // instance to pass into the engine so it can compile the views properly.
            $compiler = new TplCompiler($app['files'], $cache);


            return new CompilerEngine($compiler, $app['files']);
        });
    }

    /**
     * Register the Blade engine implementation.
     *
     * @param  \Illuminate\View\Engines\EngineResolver  $resolver
     * @return void
     */
    public function registerBladeEngine($resolver)
    {
        $app = $this->app;

        // Also register tpl engine
        $this->registerTplEngine($resolver);

        $resolver->register('blade', function() use ($app)
        {
            $cache = $app['path.storage'].'/views';

            // The Compiler engine requires an instance of the CompilerInterface, which in
            // this case will be the Blade compiler, so we'll first create the compiler
            // instance to pass into the engine so it can compile the views properly.
            $compiler = new BladeCompiler($app['files'], $cache);


            return new CompilerEngine($compiler, $app['files']);
        });
    }

    /**
     * Register the view finder implementation.
     *
     * @return void
     */
    public function registerViewFinder()
    {
        $this->app['view.finder'] = $this->app->share(function($app)
        {
            $paths = $app['config']['view.paths'];

            return new FileViewFinder($app['files'], $paths);
        });
    }

    /**
     * Register the view environment.
     *
     * @return void
     */
    public function registerEnvironment()
    {
        $this->app['view'] = $this->app->share(function($app)
        {
            // Next we need to grab the engine resolver instance that will be used by the
            // environment. The resolver will be used by an environment to get each of
            // the various engine implementations such as plain PHP or Blade engine.
            $resolver = $app['view.engine.resolver'];

            $finder = $app['view.finder'];

            $env = new Environment($resolver, $finder, $app['events']);

            // We will also set the container instance on this view environment since the
            // view composers may be classes registered in the container, which allows
            // for great testable, flexible composers for the application developer.
            $env->setContainer($app);

            $env->share('app', $app);

            return $env;
        });
    }
}