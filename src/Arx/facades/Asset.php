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

class Asset extends \Arx\classes\Facade implements \Arx\interfaces\Route {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return '\\Arx\\classes\\Asset'; }

}