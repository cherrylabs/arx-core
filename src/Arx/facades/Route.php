<?php namespace Arx\facades;
/**
 * Facade Route to hide complexity of code
 *
 * @package : Arx
 *
 */
use Arx\classes\App;
use Arx\classes\Router;
use Illuminate\Support\Facades\Facade;

class Route extends \Arx\classes\Facade implements \Arx\interfaces\Route {

    /**
     * Get routing triggered with get parameter
     *
     * @param $path
     * @param $function
     * @return Object
     */
    public static function any($path, $function)
    {

       self::resolve();
    }


    /**
     * Get routing triggered with get parameter
     *
     * @param $path
     * @param $function
     * @return Object
     */
    public static function get($path, $function)
    {
        self::resolve();
    }

    /**
     * Get routing triggered with get parameter
     *
     * @param $path
     * @param $function
     * @return Object
     */
    public static function post($path, $function)
    {
        self::resolve();
    }

    /**
     * Get routing triggered with get parameter
     *
     * @param $path
     * @param $function
     * @return Object
     */
    public static function delete($path, $function)
    {
        self::resolve();
    }

    public static function put($path, $function){
        self::resolve();
    }

    /**
     * Register a new filter with the application.
     *
     * @param  string   $name
     * @param  Closure|string  $callback
     */
    public static function filter($name, $callback)
    {
        return static::$app['router']->addFilter($name, $callback);
    }

    /**
     * Tie a registered middleware to a URI pattern.
     *
     * @param  string  $pattern
     * @param  string|array  $name
     */
    public static function when($pattern, $name)
    {
        return static::$app['router']->matchFilter($pattern, $name);
    }

    /**
     * Determine if the current route matches a given name.
     *
     * @param  string  $name
     * @return bool
     */
    public static function is($name)
    {
        return static::$app['router']->currentRouteNamed($name);
    }

    /**
     * Determine if the current route uses a given controller action.
     *
     * @param  string  $action
     * @return bool
     */
    public static function uses($action)
    {
        return static::$app['router']->currentRouteUses($action);
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'router'; }

}