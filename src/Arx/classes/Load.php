<?php namespace Arx\classes;

use Arx\classes\Html;

/**
 * Class Load
 *
 * Load media helper to handle array the output
 *
 * @package Arx\classes
 */
class Load {

    public static function js(array $array, $param = array(
		    'attributes' => array(),
		    'secure' => null
	    ))
    {

        $out = "\n";

        foreach($array as $key => $item){
            if(is_array($item)){
                $out .= Html::script($item[0], $item[1], $item[2])."\n";
            } else {
                $out .= Html::script($item, $param['attributes'], $param['secure'])."\n";
            }
        }


        return $out;
    }

    public static function css(array $array , $param = array())
    {

        $out = "\n";

        foreach($array as $key => $item){
            if(is_array($item)){
                $out .= Html::style($item[0], $item[1], $item[2])."\n";
            } else {
                $out .= Html::style($item)."\n";
            }
        }

        return $out;
    }

    public static function image(array $array , $param = array())
    {

        $out = "\n";

        foreach($array as $key => $item){
            if(is_array($item)){
                $out .= Html::image($item[0], $item[1])."\n";
            } else {
                $out .= Html::image($item)."\n";
            }
        }

        return $out;
    }
}