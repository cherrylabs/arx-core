<?php
/**
 * A Dummy class generator
 *
 * @project : ARX
 * @author : Daniel Sum <daniel@cherrypulp.com>
 */

namespace Arx\classes;


class Dummy {

    public static function image($mixSize = '400x350', $background = '000', $foregroundColor = 'fff', $text = null, $format = 'jpg'){
        return "//dummyimage.com/$mixSize/$background/$foregroundColor".(!$text ?: '&text='.urlencode($text));
    }

    public static function text($param = array()){

        $defParam = array(
            'amount' => 5,
            'what' => 'paras',
            'start' => 'yes',
            'lang' => 'en'
        );

        $param = array_merge($defParam, $param);

        $json = Utils::getJSON('http://json-lipsum.appspot.com/?'.http_build_query($param));

        if(isset($json->lipsum)){
            return implode(' -- ', $json->lipsum);
        } else {
            return 'Error Lorem ipsum dolor sit amet, consectetur adipiscing elit.';
        }
        
    }

    public static function title($param = null){

        if(is_integer($param)){
            $param = array(
                'amount' => $param
            );
        }

        if(!is_array($param)){
            $param = array();
        }

        $defParam = array(
            'amount' => 30,
            'what' => 'bytes',
            'start' => 'yes',
            'lang' => 'en'
        );

        $param = array_merge($defParam, $param);

        $json = Utils::getJSON('http://json-lipsum.appspot.com/?'.http_build_query($param));

        if(isset($json->lipsum)){
            return $json->lipsum;
        } else {
            return 'Error Lorem ipsum dolor sit amet, consectetur adipiscing elit.';
        }

    }

    public static function video($mixWidth = null, $height = null){

        $defParam = array(
            'width' => 560,
            'height' => 315,
            'src' => '//www.youtube.com/embed/0af00UcTO-c',
            'frameborder' => 0,
            'allowfullscreen' => 'true'
        );

        $param = array();

        if(is_integer($mixWidth)){
            $param['width'] = $mixWidth;
        }

        if(!$height && is_integer($height)){
            $param['height'] = $height;
        }

        $param = array_merge($defParam, $param);

        return '<iframe '.Html::attributes($param).'></iframe>';

    }

}