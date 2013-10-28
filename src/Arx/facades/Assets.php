<?php namespace Arx\facades;
/**
 * Facade Route to hide complexity of code
 *
 * @package : Arx
 *
 */
use Arx\classes\App;
use Arx\classes\Router;
use Basset\Factory\AssetFactory;
use Illuminate\Support\Facades\Facade;

class Assets extends \Arx\classes\Facade implements \Arx\interfaces\Route {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return '\\Basset\\Facade'; }

}