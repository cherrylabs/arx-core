<?php namespace Arx\classes;

class Facade
{

    /**
     * The application instance being facaded.
     *
     * @var Illuminate\Foundation\Application
     */
    protected static $app;

    /**
     * The resolved object instances.
     *
     * @var array
     */
    protected static $resolvedInstance;

    protected static $accessorName;

    /**
     * Get the root object behind the facade.
     *
     * @return mixed
     */
    public static function getFacadeRoot()
    {
        return static::resolveFacadeInstance(static::getFacadeAccessor());
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        throw new \RuntimeException("Facade does not implement getFacadeAccessor method.");
    }

    /**
     * Resolve the facade root instance from the container.
     *
     * @param  string $name
     * @return mixed
     */
    protected static function resolveFacadeInstance($name)
    {
        if (is_object($name)) return $name;

        if (isset(static::$resolvedInstance[$name])) {
            return static::$resolvedInstance[$name];
        }

        return static::$resolvedInstance[$name] = static::$app[$name];
    }

    /**
     * Clear all of the resolved instances.
     *
     * @return void
     */
    public static function clearResolvedInstances()
    {
        static::$resolvedInstance = array();
    }

    /**
     * Auto-resolve function
     *
     */
    public static function resolve(){

        $aDebug = debug_backtrace(1);

        if(isset($aDebug[1])){

            $oDebug = $aDebug[1];

            $function = $oDebug['function'];
            $class = $oDebug['class'];
            $args = $oDebug['args'];

            $app = $class::getFacadeApplication();

            return call_user_func_array( array($app[$class::getFacadeAccessor()], $function), $args);
        } else {
            Throw new Exception('Cannot resolve this function');
        }
    }

    /**
     * Get the application instance behind the facade.
     *
     * @return Illuminate\Foundation\Application
     */
    public static function getFacadeApplication()
    {
        if(empty(static::$app)){
            static::$app = App::getInstance();
        }

        return static::$app;
    }

    /**
     * Set the application instance.
     *
     * @param  Illuminate\Foundation\Application $app
     * @return void
     */
    public static function setFacadeApplication($app)
    {
        static::$app = $app;
    }

    /**
     * Handle dynamic, static calls to the object.
     *
     * @param  string $method
     * @param  array $args
     * @return mixed
     */
    public static function __callStatic($method, $args)
    {
        $instance = static::resolveFacadeInstance(static::getFacadeAccessor());

        switch (count($args)) {
            case 0:
                return $instance->$method();

            case 1:
                return $instance->$method($args[0]);

            case 2:
                return $instance->$method($args[0], $args[1]);

            case 3:
                return $instance->$method($args[0], $args[1], $args[2]);

            case 4:
                return $instance->$method($args[0], $args[1], $args[2], $args[3]);

            case 5:
                return $instance->$method($args[0], $args[1], $args[2], $args[3], $args[4]);

            default:
                return call_user_func_array(array($instance, $method), $args);
        }
    }

}