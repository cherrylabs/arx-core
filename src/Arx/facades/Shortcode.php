<?php namespace Arx\facades;

use Arx\classes\Facade;

/**
 * Class Shortcode
 *
 * Add a usefull shortcode facade
 *
 * @package Arx\facades
 */
class Shortcode extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'shortcode'; }

}