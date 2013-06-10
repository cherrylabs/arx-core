<?php namespace Arx;
/**
    * Hooked CSS
    * @file
    *
    * @package
    * @author Daniel Sum
    * @link 	@endlink
    * @see
    * @description
    *
    * @code 	@endcode
    * @comments
    * @todo
*/

require_once dirname(__FILE__).DS.'filemanager.php';

class c_hook
{

    public static $pref = "hooked_";

    public function __construct()
    {

    }

    public function __get($name)
    {
        return $GLOBALS['hooked_'.$name];
    }

    public function __set($name, $value)
    {
        return self::add($name, $value);
    }

    public static function add($name, $value)
    {
        if (!isset($GLOBALS['hooked_'.$name])) {
            $GLOBALS['hooked_'.$name] = array();
        }

        if (is_array($value)) {
            foreach ($value as $v) {
                if(!in_array($v, $GLOBALS['hooked_'.$name]))
                    $GLOBALS['hooked_'.$name][] = $v;
            }

            return $GLOBALS['hooked_'.$name];
        } else {
            if(!in_array($value, $GLOBALS['hooked_'.$name]))

                return $GLOBALS['hooked_'.$name][] = $value;
        }

    }

    /**
         * Load PHP CLASSES
         * @author Daniel Sum
         * @version 0.1
         * @package arx
         * @comments :
    */
    public static function info($c = null)
    {
        return new c_info();
    }

    /**
         * Load JS
         * @author Daniel Sum
         * @version 0.1
         * @package arx
         * @comments :
    */
    public static function js($value)
    {
        return self::add('js', $value);
    }

    /**
         * Load CSS
         * @author Daniel Sum
         * @version 0.1
         * @package arx
         * @comments :
    */
    public static function css($value)
    {
        return self::add('css', $value);
    }

        /**
         * Load JS
         * @author Daniel Sum
         * @version 0.1
         * @package arx
         * @comments :
    */
    public static function get_js($value)
    {
        $output = c_load::JS($GLOBALS[self::$pref.$c]);

        return $output;
    }

    /**
         * Load CSS
         * @author Daniel Sum
         * @version 0.1
         * @package arx
         * @comments :
    */
    public static function get_css($value)
    {
        $output = c_load::CSS($GLOBALS[self::$pref.$c]);

        return $output;
    }

    /**
         * Load PHP CLASSES
         * @author Daniel Sum
         * @version 0.1
         * @package arx
         * @comments :
    */
    public static function getAll($c = null)
    {
        return $GLOBALS['all_hooked_name'];
    }

    public static function output($c = null)
    {

        switch (true) {
            case ($c == 'js'):

                $output = c_load::JS($GLOBALS[self::$pref.$c]);

            break;
            case ($c == 'css'):

                $output = c_load::CSS($GLOBALS[self::$pref.$c]);

            break;
            default:
                $output = $GLOBALS[self::$pref.$c];
            break;
        }

        return $output;
    }

    public function get($c){
        return self::output($c);
    }

    public function eput($c){
        echo self::output($c);
    }

    public function start($str){
        ob_start();
    }

    public function end($str){
        $GLOBALS[self::$pref.$str] .= ob_get_contents();
        ob_end_clean();
    }

    /**
         * preLoad function
         * @author Daniel Sum
         * @version 0.1
         * @package arx
    */
    public static function preload($c = null){

    }

    /**
         * preLoad function
         * @author Daniel Sum
         * @version 0.1
         * @package arx
         * @comments : TODO
    */
    public static function postload($c = null){
        return true;
    }

}

if (!isset($arx_hook)) {
    $GLOBALS[ARX_HOOK] = new c_hook();
}
