<?php namespace Arx\classes;

/**
 * Debug
 *
 * @category Debug
 * @package  Arx
 * @author   Stéphan Zych <stephan@cherrypulp.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @link     http://arx.xxx/doc/Debug
 *
 * @example
 * Debug::getInstance()->benchmark()->includes()->time('file loaded');
 * Debug::log('var_dump() without die()', $array, $int);
 * Debug::dump('var_dump() with die()', $array)->time('dump end actions');
 */
class Debug extends Singleton
{

    // --- Constants


    // --- Public members

    public $reporting = E_ALL; // false = turn off


    // --- Protected members


    // --- Private members


    // --- Magic methods

    public static function __callStatic($sName, $mValue) {} // __callStatic

    public function __construct() {} // __construct

    public function __get($sName) {} // __get

    public function __set($sName, $mValue) {} // __set


    // --- Public methods

    public function backtrace() {} // backtrace

    public function benchmark() {} // benchmark

    public function classes() {} // classes

    public function constants() {} // constants

    public function dump() {} // dump

    public function extensions() {} // extensions

    public function format() {} // format

    public function functions() {} // functions

    public function headers() {} // headers

    public function includes() {} // includes

    public function interfaces() {} // interfaces

    public function lines() {} // lines

    public function log() {} // log

    public function phpinfo() {} // phpinfo

    public function reporting() {} // reporting

    public function time() {} // time


    // --- Protected methods


    // --- Private methods


} // class::Debug


// <?php namespace Arx\classes;

// class Debug {


//     public function notice($error_msg, $error_type = "E_USER_NOTICE")
//     {
//         trigger_error($error_msg, $error_type);
//     }

//     /**
//      * @param $error_msg
//      * @param $error_type
//      * @todo more complexe error tracing
//      */
//     public function error($error_msg, $error_type){
//        trigger_error($error_msg, $error_type);
//     }
// }
