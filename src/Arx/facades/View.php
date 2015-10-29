<?php namespace Arx\facades;

/**
 * Class View
 *
 * Override default View facade
 *
 * @package Arx\facades
 */
class View extends \Arx\classes\Facade {
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'view'; }

    /**
     * Get a evaluated view contents for the given view.
     *
     * @param  string  $view
     * @param  array   $data
     * @param  array   $mergeData
     * @return \Illuminate\View\View
     */
    public static function make($view, $data = array(), $mergeData = array())
    {
       return self::resolve($view, $data, $mergeData);
    }

}