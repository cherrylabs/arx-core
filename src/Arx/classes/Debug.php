<?php namespace Arx\classes;

use Arx\classes\debug\Kint;
use DebugBar\StandardDebugBar;
use App;

/**
 * Class Debug handler using Kint
 *
 * extends the DebugBar\StandardDebugBar class
 *
 * @todo method according PSR-3 LOG
 * @package Arx\classes
 */
class Debug extends Singleton
{
    public static $traceCleanupCallback;
    public static $fileLinkFormat;
    public static $hideSequentialKeys;
    public static $showClassConstants;
    public static $keyFilterCallback;
    public static $displayCalledFrom;
    public static $charEncodings;
    public static $maxStrLength;
    public static $appRootDirs;
    public static $maxLevels;
    public static $enabled;
    public static $theme;
    public static $expandedByDefault;

    protected static $_firstRun = true;

    # non-standard function calls
    protected static $_statements = array('include', 'include_once', 'require', 'require_once');

    public function __construct()
    {
        if (class_exists('\Debugbar')) {
            return App::make('Debugbar');
        } else {
            return new StandardDebugBar();
        }
    }

    public static function dump($data = null)
    {
        return Kint::dump($data);
    }

    /**
     * @param null $data
     */
    public static function trace($data = null){
        Kint::trace($data);
    }

    /**
     * Define Debug deep level
     *
     * @param $i
     */
    public static function level($level){
        Kint::$maxLevels = $level;
    }

} // class::Debug
