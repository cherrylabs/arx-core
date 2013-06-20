<?php namespace Arx;

/**
 * Class h_jquery
 * @package Arx
 */
class h_jquery {
    /**
     * Assign variable
     *
     * @param $
     * @return
     * @code
     * @endcode
     */

    public $prepend = '<script type="text/javascript">';
    public $selector = '$';
    public $append = '</script>';

    public function __construct($args = null) {} // __construct

    public function __call($function, $name) {} // __call

    /**
     * domReady function accept a parameter that you can charge
     *
     * @param $
     * @return
     * @code
     * @endcode
     */
    public static function domReady($script, &$var = null) {
        if (!$var) {
            return '<script type="text/javascript">'.'$(function() {'.$script.'});'.'</script>';
        } else {
            if (!isset($var['prepend'])) {
                $var['prepend'] = self::$prepend;
            }

            $var['domReady'][] = $script;

            if (!isset($var['append'])) {
                $var['append'] = self::$append;
            }

            return true;
        }
    } // domReady

    /**
     * output
     *
     * @param $
     * @return
     * @code
     * @endcode
     */

    public static function output(&$var = null) {
        if (!$var) {
            return '<script type="text/javascript">'.
            self::$selector.'(function() {
                '.$script.'
            });'.'</script>';
        } else {
            if (!isset($var['prepend'])) {
                $var['prepend'] = self::$prepend;
            }

            $var['domReady'][] = $script;

            if (!isset($var['append'])) {
                $var['append'] = self::$append;
            }

            return true;
        }

        return false;
    } // output

} // adapter:a_jquery
