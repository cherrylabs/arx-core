<?php namespace Arx\classes;

/**
 * Class Hook
 *
 * Little class to add easily a hook system to any kind of project
 *
 * @example
 *
 * Hook::put('var1.var2', ['data']);
 * Hook::
 *
 * #output
 *
 * @package Arx\classes
 */
class Hook extends \ArrayObject
{
    public static $pref = "";

    public static $logs = array();

    public static $callback = array();

    public static $debug = true;

    public function __get($name)
    {
        return $GLOBALS[ARX_HOOK][$name];
    }

    public function __set($name, $value)
    {
        return self::put($name, $value);
    }

    /**
     * Check if Hook has key
     * @param $key
     * @return bool
     */
    public static function has($key)
    {
        return self::get($key) ? true : false;
    }

    public static function register($name, $callback = null){
        $GLOBALS[ARX_HOOK][$name] = array();
        self::$callback[$name] = array($callback);
    }

    public static function log($action, $name, $params = array()){

        if(!isset($logs[$action])){
            self::$logs[$action] = array();
        }

        self::$logs[$action][$name][] = array(
            'params' => $params,
            'debug' => debug_backtrace(),
        );
    }

    public static function logs(){
        return self::$logs;
    }

    /**
     * @param $name
     * @param $mValue
     * @param null $merge
     * @return mixed
     * @deprecated please use put instead
     * @internal param $value
     *
     */
    public static function add($name, $mValue, $merge = null)
    {
        return self::put($name, $mValue);
    }

    /**
     * Force to set hook value
     *
     * @param $name
     * @param array $mValue
     * @return mixed
     */
    public static function set($name, $mValue = array()){
        return $GLOBALS[ARX_HOOK][$name] = $mValue;
    }

    /**
     * Put data
     *
     * @param $name
     * @param array $mValue
     * @param null $merge
     * @return mixed
     * @throws \Exception
     */
    public static function put($name, $mValue = array(), $merge = null){

        if ($pos = strpos($name, '.')) {
            $dots = substr($name, $pos + 1);
            $name = substr($name, 0, $pos);
        }

        if (!isset($GLOBALS[ARX_HOOK][$name])) {
            $GLOBALS[ARX_HOOK][$name] = array();
            self::log('add', $name, func_get_args());
        }

        if(!is_string($mValue) && $merge === null && !is_bool($mValue) && !Arr::is_sequential($mValue)){
            $merge = true;
        }

        if(isset($dots)){
            Arr::set($GLOBALS[ARX_HOOK][$name], $dots, $mValue);
        } elseif ($merge) {
            if (is_string($mValue)) {
                $mValue = array($mValue);
            }
            $GLOBALS[ARX_HOOK][$name] =  Arr::merge($GLOBALS[ARX_HOOK][$name], $mValue);
        } elseif (is_array($mValue)) {
            foreach ($mValue as $v) {
                if(!in_array($v, $GLOBALS[ARX_HOOK][$name])){
                    $GLOBALS[ARX_HOOK][$name][] = $v;
                }
            }
        } else {
            if(!in_array($mValue, $GLOBALS[ARX_HOOK][$name])){
                $GLOBALS[ARX_HOOK][$name][] = $mValue;
            }
        }

        return $GLOBALS[ARX_HOOK][$name];
    }

    public static function putJsVars($mValue = array(), $name = 'gVars'){
        return self::put('gVars', $mValue);
    }

    /**
     * Load JS
     * @author Daniel Sum
     * @version 0.1
     * @package arx
     * @comments :
     */
    public static function js($name = 'js')
    {
        return Asset::js(Hook::get($name));
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
     * Load JS
     * @author Daniel Sum
     * @version 0.1
     * @package arx
     * @comments :
     */
    public static function getJs($name = 'js')
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
    public static function getCss($name = 'css')
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

    /**
     * Get registered hook
     *
     * @param $name
     * @param null $default
     * @return array
     */
    public static function get($name, $default = null){

        $dots = null;

        if ($pos = strpos($name, '.')) {
            $dots = substr($name, $pos + 1);
            $name = substr($name, 0, $pos);
        }

        if(isset($GLOBALS[ARX_HOOK][$name])){

            if ($dots) {
                return Arr::get($GLOBALS[ARX_HOOK][$name], $dots, $default);
            }

            return $GLOBALS[ARX_HOOK][$name];
        }

        if ($default) {
            return $default;
        }

        return [];
    }

    /**
     * Little helper to output hook
     *
     * @param $name
     * @param $default
     */
    public static function ddget($name, $default){
        dd($name, $default);
    }

    /**
     * Output json type
     *
     * @param $name
     * @param $default
     * @return string
     */
    public static function getJson($name, $default = array()){
        return json_encode(self::get($name, $default));
    }

    public static function eput($c){
        echo self::output($c);
    }

    /**
     * Start method put your output in memory cache until you end
     *
     * @param $name
     * @param null $key
     *
     */
    public static  function start($name, $key = null){
        if ($key) {
            $GLOBALS[ARX_HOOK][$name][$key] = '';
        } else {
            $GLOBALS[ARX_HOOK][$name] = '';
        }
        ob_start();
    }

    /**
     * End your cached data and save it in a globals
     * @param $name
     * @param null $key
     */
    public static function end($name, $key = null){

        if ($key) {
            $GLOBALS[ARX_HOOK][$name][$key] = ob_get_contents();
        } else {
            $GLOBALS[ARX_HOOK][$name] = ob_get_contents();
        }

        ob_end_clean();
    }
} // class::Hook

/**
 * Register a global arx_hook element
 */
if(!defined('ARX_HOOK')) define('ARX_HOOK', 'ARX_HOOK');

if (!isset($GLOBALS[ARX_HOOK])) {
    $GLOBALS[ARX_HOOK] = new Hook();
}
