<?php namespace Arx\classes;

use Arx\classes\Html;

/**
 * Class Load
 *
 * Load a file or a link and handle the output
 *
 * @todo better implementation of this class
 * @package Arx\classes
 */
class Load {

    /**
     * Load a js file and output html script
     *
     * @param $array
     * @param array $param
     * @return string
     */
    public static function js($array, $param = array())
    {

        $out = "\n";

        foreach($array as $key => $item){
            if(is_array($item)){
                $out .= Html::script($item[0], $item[1])."\n";
            } else {
                $out .= Html::script($item)."\n";
            }
        }


        return $out;
    }


    /**
     * Load a css file and output html script
     *
     * @param $array
     * @param array $param
     * @return string
     */
    public static function css($array , $param = array())
    {

        $out = "\n";

        foreach($array as $key => $item){
            if(is_array($item)){
                $out .= Html::style($item[0], $item[1])."\n";
            } else {
                $out .= Html::style($item)."\n";
            }
        }

        return $out;
    }

    /**
     * Load a css file and output html script
     *
     * @param $array
     * @param array $param
     * @return string
     */
    public static function image($array , $param = array())
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