<?php namespace Arx\classes;

use Illuminate\Html\HtmlBuilder;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteCollection;
use Illuminate\Routing\UrlGenerator;

/**
 * Class Html adapter
 *
 * Extends Illuminate HTML class
 *
 * @package Arx\classes
 */
class Html extends Singleton {

    protected $html;

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

}
