<?php namespace Arx\classes;

use Arx;

/**
 * Class Assets
 *
 * Smarter assets handler => if production js and css will be compiled on the fly
 *
 * @package Arx\classes
 */
class Assets extends singleton {

    protected $_aInstances = array();

    public static function js($data = array(), $param = array(
            'compiled' => false
        )){

        return Load::js($data);
    }

    public static function css($data = array(), $param = array(
            'compiled' => false
        )){

        return Load::css($data);
    }
} 