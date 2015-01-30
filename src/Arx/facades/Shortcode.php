<?php namespace Arx\facades;

use Arx\classes\Facade;

class Shortcode extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'shortcode'; }

}