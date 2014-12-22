<?php namespace Arx\classes;

use Arx;

/**
 * Class Assets
 *
 * Smarter assets handler => if production js and css will be compiled on the fly
 *
 * @todo handle production|dev environment
 * @package Arx\classes
 */
class Asset extends singleton {

    protected $_aInstances = array();

    /**
     * Output js
     *
     * @param array $data
     * @param array $param
     * @return string
     */
    public static function js($data = array(), $param = array(
            'compiled' => false
        )){

        return Load::js($data);
    }

    /**
     * Output css
     *
     * @param array $data
     * @param array $param
     * @return string
     */
    public static function css($data = array(), $param = array(
            'compiled' => false
        )){

        return Load::css($data);
    }
} 