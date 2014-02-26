<?php namespace Arx\classes;

use DebugBar\StandardDebugBar;
use App;
use ReflectionMethod;
use Arx\classes\debug\Kint;

/**
 * Class Debug handler
 *
 * extends the DebugBar\StandardDebugBar class
 *
 * @todo method according PSR-3 LOGcompos
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

    public static function trace($data = null){
        return Kint::trace($data);
    }

} // class::Debug
