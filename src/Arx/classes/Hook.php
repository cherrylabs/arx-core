<?php namespace Arx\classes;

/**
 * Hook class
 *
 * Class helper to manage easily a hook flow
 * @example
 *  Hook::add('{name}', array('{link}');
 * @category Hook
 * @package  Arx
 * @author   Daniel Sum <daniel@cherrypulp.com>
 * @author   Stéphan Zych <stephan@cherrypulp.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @link     http://arx.xxx/doc/Hook
 */

class Hook extends Container
{
    public static $pref = "hooked_";

    public function __get($name)
    {
        return $GLOBALS[self::$pref.$name];
    }

    public function __set($name, $value)
    {
        return self::add($name, $value);
    }

    /**
     * @param $name
     * @param $value
     *
     * @return mixed
     */
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
     * Load JS
     * @author Daniel Sum
     * @version 0.1
     * @package arx
     * @comments :
     */
    public static function js($name = 'js')
    {

        if(is_string($value)){
            $value = array($value);
        }
        return self::add('js', $value);
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
        $t = self::getInstance();

    }

    public static function html($name = 'html'){

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
        $output = Load::JS($GLOBALS[self::$pref.$c]);

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
        $output = Load::CSS($GLOBALS[self::$pref.$c]);

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

        if(isset($GLOBALS[self::$pref.$c])){
            switch (true) {
                case ($c == 'js'):

                    $output = Load::JS($GLOBALS[self::$pref.$c]);

                    break;
                case ($c == 'css'):

                    $output = Load::CSS($GLOBALS[self::$pref.$c]);

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

    public function get($c){
        return self::output($c);
    }

    public function eput($c){
        echo self::output($c);
    }

    /**
     * Start method put your output in memory cache until you end
     * @param $str
     */
    public function start($name){
        ob_start();
    }

    /**
     * End your cached data and save it in a globals
     * @param $name
     */
    public function end($name){
        $GLOBALS[self::$pref.$name] .= ob_get_contents();
        ob_end_clean();
    }
} // class::Hook

/**
 * Init the global arx_hook
 */
if (!isset($GLOBALS['arx_hook'])) {
    $GLOBALS['arx_hook'] = new Hook();
}
