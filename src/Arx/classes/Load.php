<?php namespace Arx\classes;
use Illuminate\Http\Request;

/**
 * Class Load
 *
 * Load media helper to handle array the output
 *
 * @package Arx\classes
 */
class Load {

    /**
     * Load and output a js script tag from array
     *
     * @param array $array
     * @param array $params
     * @return string
     * @throws \Exception
     */
    public static function js(array $array, $params = array(
        'attributes' => array(),
        'secure' => null
    ))
    {
        Arr::mergeWithDefaultParams($params);

        if (!$params['secure']) {
            try {
                $params['secure'] = Utils::isHTTPS();
            } catch (Exception $e) {

            }
        }

        $out = "\n";

        foreach($array as $key => $item){
            if(is_array($item)){
                $out .= Html::script($item[0], $item[1], $item[2])."\n";
            } else {
                $out .= Html::script($item, $params['attributes'] ?: [], $params['secure'])."\n";
            }
        }


        return $out;
    }

    /**
     * Load and output a css link tag from array
     *
     * @param array $array
     * @param array $params
     * @return string
     * @throws \Exception
     */
    public static function css(array $array , $params = array(
        'attributes' => [],
        'secure' => null
    ))
    {
        Arr::mergeWithDefaultParams($params);

        if (!$params['secure']) {
            try {
                $params['secure'] = Utils::isHTTPS();
            } catch (Exception $e) {

            }
        }

        $out = "\n";

        foreach($array as $key => $item){
            if(is_array($item)){
                $out .= Html::style($item[0], $item[1], $item[2])."\n";
            } else {
                $out .= Html::style($item, $params['attributes'], $params['secure'])."\n";
            }
        }

        return $out;
    }

    /**
     * Output HTML image tag from array
     *
     * @param array $array
     * @param array $param
     * @return string
     */
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