<?php namespace Arx\classes;

use Illuminate\Html\HtmlBuilder;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteCollection;
use Illuminate\Routing\UrlGenerator;

/**
 * Class Html adapted from Laravel HTML
 *
 * Add some usefull method to the HTML laravel class
 *
 * @compatibility Laravel
 * @needs Illuminate\Html, Illuminate\Routing, Illuminate\Http to work as stand-alone
 * @see http://laravel.com/api/4.2/Illuminate/Html/HtmlBuilder.html
 *
 * @package Arx\classes
 */
class Html extends Singleton {

    protected $html;

    /**
     * Check if HTML is loaded => else we create a new instance
     */
    public function __construct(){

        if(class_exists('\\HTML', true)){

            $this->html = '\\HTML';

        } else {

            # Try to load HTML helpers without config
            $this->route = new RouteCollection();

            $this->request = new Request();

            $this->url = new UrlGenerator($this->route, $this->request);

            $this->html = new HtmlBuilder($this->url);
        }
    }

    public static function __callStatic($name, $args){
        $html = self::getInstance()->html;
        return call_user_func_array(array($html, $name), $args);
    }

    /**
     * Register a custom HTML macro.
     *
     * @param  string    $name
     * @param  callable  $macro
     * @return void
     */
    public static function macro($name, $macro)
    {
        $html = self::getInstance()->html;
        $args = func_get_args();
        call_user_func_array(array($html, __FUNCTION__), $args);
    }

    /**
     * Convert an HTML string to entities.
     *
     * @param  string  $value
     * @return string
     */
    public static function entities($value)
    {
        $html = self::getInstance()->html;
        $args = func_get_args();
        return call_user_func_array(array($html, __FUNCTION__), $args);
    }

    /**
     * Convert entities to HTML characters.
     *
     * @param  string  $value
     * @return string
     */
    public static function decode($value)
    {
        $html = self::getInstance()->html;
        $args = func_get_args();
        return call_user_func_array(array($html, __FUNCTION__), $args);
    }

    /**
     * Generate a link to a JavaScript file.
     *
     * @param  string  $url
     * @param  array   $attributes
     * @param  bool    $secure
     * @return string
     */
    public static function script($url, $attributes = array(), $secure = null)
    {
        $html = self::getInstance()->html;
        $args = func_get_args();
        return call_user_func_array(array($html, __FUNCTION__), $args);
    }

    /**
     * Generate a link to a CSS file.
     *
     * @param  string  $url
     * @param  array   $attributes
     * @param  bool    $secure
     * @return string
     */
    public static function style($url, $attributes = array(), $secure = null)
    {
        $html = self::getInstance()->html;
        $args = func_get_args();
        return call_user_func_array(array($html, __FUNCTION__), $args);
    }

    /**
     * Generate an HTML image element.
     *
     * @param  string  $url
     * @param  string  $alt
     * @param  array   $attributes
     * @param  bool    $secure
     * @return string
     */
    public static function image($url, $alt = null, $attributes = array(), $secure = null)
    {
        $html = self::getInstance()->html;
        $args = func_get_args();
        return call_user_func_array(array($html, __FUNCTION__), $args);
    }

    /**
     * Generate a HTML link.
     *
     * @param  string  $url
     * @param  string  $title
     * @param  array   $attributes
     * @param  bool    $secure
     * @return string
     */
    public static function link($url, $title = null, $attributes = array(), $secure = null)
    {
        $html = self::getInstance()->html;
        $args = func_get_args();
        return call_user_func_array(array($html, __FUNCTION__), $args);
    }

    /**
     * Generate a HTTPS HTML link.
     *
     * @param  string  $url
     * @param  string  $title
     * @param  array   $attributes
     * @return string
     */
    public static function secureLink($url, $title = null, $attributes = array())
    {
        $html = self::getInstance()->html;
        $args = func_get_args();
        return call_user_func_array(array($html, __FUNCTION__), $args);
    }

    /**
     * Generate a HTML link to an asset.
     *
     * @param  string  $url
     * @param  string  $title
     * @param  array   $attributes
     * @param  bool    $secure
     * @return string
     */
    public static function linkAsset($url, $title = null, $attributes = array(), $secure = null)
    {
        $html = self::getInstance()->html;
        $args = func_get_args();
        return call_user_func_array(array($html, __FUNCTION__), $args);
    }

    /**
     * Generate a HTTPS HTML link to an asset.
     *
     * @param  string  $url
     * @param  string  $title
     * @param  array   $attributes
     * @return string
     */
    public static function linkSecureAsset($url, $title = null, $attributes = array())
    {
        $html = self::getInstance()->html;
        $args = func_get_args();
        return call_user_func_array(array($html, __FUNCTION__), $args);
    }

    /**
     * Generate a HTML link to a named route.
     *
     * @param  string  $name
     * @param  string  $title
     * @param  array   $parameters
     * @param  array   $attributes
     * @return string
     */
    public static function linkRoute($name, $title = null, $parameters = array(), $attributes = array())
    {
        $html = self::getInstance()->html;
        $args = func_get_args();
        return call_user_func_array(array($html, __FUNCTION__), $args);
    }

    /**
     * Generate a HTML link to a controller action.
     *
     * @param  string  $action
     * @param  string  $title
     * @param  array   $parameters
     * @param  array   $attributes
     * @return string
     */
    public static function linkAction($action, $title = null, $parameters = array(), $attributes = array())
    {
        $html = self::getInstance()->html;
        $args = func_get_args();
        return call_user_func_array(array($html, __FUNCTION__), $args);
    }

    /**
     * Generate a HTML link to an email address.
     *
     * @param  string  $email
     * @param  string  $title
     * @param  array   $attributes
     * @return string
     */
    public static function mailto($email, $title = null, $attributes = array())
    {
        $html = self::getInstance()->html;
        $args = func_get_args();
        return call_user_func_array(array($html, __FUNCTION__), $args);
    }

    /**
     * Obfuscate an e-mail address to prevent spam-bots from sniffing it.
     *
     * @param  string  $email
     * @return string
     */
    public static function email($email)
    {
        $html = self::getInstance()->html;
        $args = func_get_args();
        return call_user_func_array(array($html, __FUNCTION__), $args);
    }

    /**
     * Generate an ordered list of items.
     *
     * @param  array   $list
     * @param  array   $attributes
     * @return string
     */
    public static function ol($list, $attributes = array())
    {
        $html = self::getInstance()->html;
        $args = func_get_args();
        return call_user_func_array(array($html, __FUNCTION__), $args);
    }

    /**
     * Generate an un-ordered list of items.
     *
     * @param  array   $list
     * @param  array   $attributes
     * @return string
     */
    public static function ul($list, $attributes = array())
    {
        $html = self::getInstance()->html;
        $args = func_get_args();
        return call_user_func_array(array($html, __FUNCTION__), $args);
    }

    /**
     * Create a listing HTML element.
     *
     * @param  string  $type
     * @param  array   $list
     * @param  array   $attributes
     * @return string
     */
    protected function listing($type, $list, $attributes = array())
    {
        $html = self::getInstance()->html;
        $args = func_get_args();
        return call_user_func_array(array($html, __FUNCTION__), $args);
    }

    /**
     * Create the HTML for a listing element.
     *
     * @param  mixed    $key
     * @param  string  $type
     * @param  string  $value
     * @return string
     */
    protected function listingElement($key, $type, $value)
    {
        $html = self::getInstance()->html;
        $args = func_get_args();
        return call_user_func_array(array($html, __FUNCTION__), $args);
    }

    /**
     * Create the HTML for a nested listing attribute.
     *
     * @param  mixed    $key
     * @param  string  $type
     * @param  string  $value
     * @return string
     */
    protected function nestedListing($key, $type, $value)
    {
        $html = self::getInstance()->html;
        $args = func_get_args();
        return call_user_func_array(array($html, __FUNCTION__), $args);
    }

    /**
     * Build an HTML attribute string from an array.
     *
     * @param  array  $attributes
     * @return string
     */
    public static function attributes($attributes)
    {
        $html = self::getInstance()->html;
        $args = func_get_args();
        return call_user_func_array(array($html, __FUNCTION__), $args);
    }

    /**
     * Build a single attribute element.
     *
     * @param  string  $key
     * @param  string  $value
     * @return string
     */
    protected function attributeElement($key, $value)
    {
        $html = self::getInstance()->html;
        $args = func_get_args();
        return call_user_func_array(array($html, __FUNCTION__), $args);
    }

    /**
     * Obfuscate a string to prevent spam-bots from sniffing it.
     *
     * @param  string  $value
     * @return string
     */
    public static function obfuscate($value)
    {
        $html = self::getInstance()->html;
        $args = func_get_args();
        return call_user_func_array(array($html, __FUNCTION__), $args);
    }

}
