<?php
/**
 * bootstrap helper class
 *
 * @project : arx-contrib
 * @author : Daniel Sum <daniel@cherrypulp.com>
 */

namespace Arx\helpers;


use Arx\classes\Helper;
use HTML;

class Bootstrap extends Helper {

    public static function nav($data, $active = null, $attributes = array('class' => 'nav'), $tag = 'ul'){
        $html = '<'.$tag.' '.HTML::attributes($attributes).'>';

        foreach($data as $key => $value){
            $html .= '<li '.(isset($value['@ttr']) ? HTML::attributes($value['@ttr']) : '').'>';
            $html .= '<a href="'.$value['link'].'"' . (isset($value['link@ttr']) ? HTML::attributes($value['link@ttr']) : '') .'>'.$value['name'].'</a>';
            $html .= '</li>';
        }

        $html .= '</'.$tag.'>';

        return $html;
    }
}