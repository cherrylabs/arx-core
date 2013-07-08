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

    public static $reporting = E_ALL; // false = turn off

    /**
     * A string identifier for a known IDE/text editor, or a closure
     * that resolves a string that can be used to open a given file
     * in an editor. If the string contains the special substrings
     * %file or %line, they will be replaced with the correct data.
     *
     * @example
     *  "txmt://open?url=%file&line=%line"
     * @var mixed $editor
     */
    public static $editor;


    // --- Protected members

    /**
     * Return an accordion with:
     * title: current filepath, current line number and total execution time (ex. '/classes/Debug.php @ line 13 - 112.45 ms')
     * tabs: trace(function executed with time), files included, globals var, memory usage
     *
     * @var array $output
     */
    protected $output = array();


    // --- Private members

    /**
     * A list of known editor strings
     * @var array
     */
    private static $_editors = array(
        'sublime'  => 'subl://open?url=file://%file&line=%line',
        'textmate' => 'txmt://open?url=file://%file&line=%line',
        'emacs'    => 'emacs://open?url=file://%file&line=%line',
        'macvim'   => 'mvim://open/?url=file://%file&line=%line'
    );

    private static $_isStylesheet = false;


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

    public static function dump() {
        $datas = array();
        $backtrace = debug_backtrace();

        // locate the first file entry that isn't this class itself
        foreach ($backtrace as $stack => $trace) {
            if (isset($trace['file'])) {
                // If being called from within, show the file above in the backtrack
                if (strpos($trace['file'], 'classes/Debug.php') !== FALSE) {
                    $callee = $backtrace[$stack+1];
                    $label = \Inflector::humanize($backtrace[$stack+1]['function']);
                } else {
                    $callee = $trace;
                    $label = 'Debug';
                }

                $callee['file'] = $callee['file'];

                break;
            }
        }

        $arguments = func_get_args();

        foreach ($arguments as $argument) {
            $data = array();

            $data['title'] = $callee['file'].' @line '.$callee['line'];
            $data['content'] = $argument[0];

            $datas[] = $data;
        }

        die(self::format($datas));
    } // dump

    public function extensions() {} // extensions

    public static function format($datas)
    {
        $output = '';

        if (self::$_isStylesheet === false) {
            $output .= '<style>'.file_get_contents(__DIR__.'/../assets/stylesheets/bootstrap.min.css').'</style>';
            $output .= '<script>'.file_get_contents(__DIR__.'/../assets/javascripts/jquery-2.0.3.min.js').'</script>';
            $output .= '<script>'.file_get_contents(__DIR__.'/../assets/javascripts/bootstrap.min.js').'</script>';
            self::$_isStylesheet = true;
        }

        $output .= '<div class="accordion" id="arx-debug-dump">';

        foreach ($datas as $data) {
            $id = uniqid('arx-');

            $output .= '<div class="accordion-group"><div class="accordion-heading">';
            $output .= '<a class="accordion-toggle" data-toggle="collapse" data-parent="arx-debug-dump" href="#'.$id.'">'.$data['title'].'</a>';
            $output .= '<div id="'.$id.'" class="accordion-body collapse"><div class="accordion-inner">';

            $output .= $data['content'];

            $output .= '</div></div>';
            $output .= '</div></div>';
        }

        $output .= '</div>';

        return $output;
    } // format

    public function functions() {} // functions

    public function headers() {} // headers

    public function includes() {} // includes

    public function interfaces() {} // interfaces

    public function lines() {} // lines

    public function log() {} // log

    public static function off() {
        self::$reporting = false;
    } // off

    public static function on($reporting = E_ALL) {
        self::$reporting = $reporting;
    } // on

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
