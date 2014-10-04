<?php namespace Arx\classes;

if(!defined('ARX_HOOK')) define('ARX_HOOK', 'ARX_HOOK');

/**
 * Class Hook
 *
 * @package Arx\classes
 */
class Hook extends \ArrayObject
{
    public static $pref = "";

    public static $logs = array();

    public static $callback = array();

    public function __get($name)
    {
        return $GLOBALS[ARX_HOOK][$name];
    }

    public function __set($name, $value)
    {
        return self::add($name, $value);
    }

    public static function register($name, $callback = null){
        $GLOBALS[ARX_HOOK][$name] = array();
        self::$callback[$name] = array($callback);
    }

    /**
     * @param $name
     * @param $value
     *
     * @return mixed
     */
    public static function add($name, $mValue)
    {

        if (!isset($GLOBALS[ARX_HOOK][$name])) {
            $GLOBALS[ARX_HOOK][$name] = array();
        }

        if (is_array($mValue)) {
            foreach ($mValue as $v) {
                if(!in_array($v, $GLOBALS[ARX_HOOK][$name]))
                    $GLOBALS[ARX_HOOK][$name][] = $v;
            }

            return $GLOBALS[ARX_HOOK][$name];
        } else {
            if(!in_array($mValue, $GLOBALS[ARX_HOOK][$name])){
                return $GLOBALS[ARX_HOOK][$name][] = $mValue;
            }
        }

        return $GLOBALS[ARX_HOOK][$name];

    }

    /**
     * Set a new hook
     *
     * @param $name
     * @param array $mValue
     */
    public static function set($name, $mValue = array()){

    }

    /**
     * Load JS
     * @author Daniel Sum
     * @version 0.1
     * @package arx
     * @comments :
     */
    public static function js($name)
    {
        return Asset::css(Hook::get($name));
    }

    /**
     * Load CSS file
     * @author Daniel Sum
     * @version 0.1
     * @package arx
     * @comments :
     */
    public static function css($name = 'css')
    {
        return Asset::css(Hook::get($name));
    }

    /**
     * Output content as HTML
     *
     * @param string $name
     */
    public static function html($name = 'html'){

    }

    /**
     * Load JS
     * @author Daniel Sum
     * @version 0.1
     * @package arx
     * @comments :
     */
    public static function getJs($name)
    {
        $output = Load::JS($GLOBALS[self::$pref.$name]);

        return $output;
    }

    /**
     * Load CSS
     * @author Daniel Sum
     * @version 0.1
     * @package arx
     * @comments :
     */
    public static function getCss($name)
    {
        $output = Load::CSS($GLOBALS[self::$pref.$name]);

        return $output;
    }

    /**
     * Load PHP CLASSES
     * @author Daniel Sum
     * @version 0.1
     * @package arx
     * @comments :
     */
    public static function getAll()
    {
        return $GLOBALS[ARX_HOOK];
    }

    /**
     * Output hook
     *
     * @return bool
     */
    public static function output()
    {
        
        $aArgs = func_get_args();
        $iArgs = func_num_args();

        $c = $aArgs[0];
        
        if(isset($GLOBALS[self::$pref.$c])){
            switch (true) {
                case ($c == 'js'):

                    $output = Asset::dump($GLOBALS[self::$pref.$c]);

                    break;
                case ($c == 'css'):
                    $output = Asset::dump($GLOBALS[self::$pref.$c]);
                    break;
                default:
                    $output = $GLOBALS[self::$pref.$c];
                    break;
            }
        } else {
            $output = false;
        }



        return $output;
    }

    public static function get($name){

        if(isset($GLOBALS[ARX_HOOK][$name])){

            return $GLOBALS[ARX_HOOK][$name];
        }

        return false;
    }

    public static function eput($c){
        echo self::output($c);
    }

    /**
     * Start method put your output in memory cache until you end
     * @param $str
     */
    public static  function start($name){
        $GLOBALS[ARX_HOOK][$name] = '';
        ob_start();
    }

    /**
     * End your cached data and save it in a globals
     * @param $name
     */
    public static function end($name){
        $GLOBALS[ARX_HOOK][$name] .= ob_get_contents();
        ob_end_clean();
    }
} // class::Hook

/**
 * Init the global arx_hook
 */
if (!isset($GLOBALS[ARX_HOOK])) {
    //$GLOBALS[ARX_HOOK] = new Hook();
}
