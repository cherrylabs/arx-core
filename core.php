<?php

/**
 * ARX The refexive kit.
 * PHP File - /arx/core.php
 *
 * @description     Core File
 * @package         arx
 * @author          Daniel Sum, Stéphan Zych
 * @version         1.0
 */

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.php';

// Minimum classes requirements:
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'utils.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'singleton.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'config.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'load.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'hook.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'filemanager.php';

require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'vendor/autoload.php';

use Arx\c_config as Config;

/**
 * Arx
 *
 * @class           Arx
 * @description     Core class
 * @dependency      /a-config.php (global $aConfig), /classes/utils.php
 * @example:
 *      $app = new Arx(array('orm' => 'redbean'));
 *  or
 *      $app = new Arx('{orm: redbean}');
 */

class Arx extends c_singleton
{

    const VERSION = '1.0';
    const CODENAME = 'Lupa';


    // --- Private members

    public $_oApp;
    private $_oHook;
    private $_oLoad;
    private $_oRoute;
    private $_oTpl;
    private $_oOrm;
    private $_oInstance;

    private $_aConfig = array();
    public $_aAliases = array();


    /**
     * Magic constructor by default load default config
     */
    public function __construct()
    {

        $aArgs = func_get_args();
        $iArgs = func_num_args();

        if (isset($aArgs[0])) {
            if (isset($aArgs[1]) && $aArgs[1] == true) {
                $config = Config::load();
            } else {
                $config = array_merge($aArgs[0], Config::load());
            }
        } else {
            $config = Config::load();
        }

        $this->_oApp = new $config['system']['app'];
        $this->_oTpl = new $config['system']['template']();
        $this->_oRoute = new $config['system']['route']();
        $this->_oTpl->error = array();
    } // __construct

    /**
     * Magic call resolver check if method in each class defined by this order : app, tpl, route, aliases
     * @param $sName
     * @param $mArgs
     * @return object
     */
    public function __call($sName, $mArgs)
    {
        switch (true) {
            // Router
            case method_exists($this->_oApp, $sName):
                return call_user_func_array(array($this->_oApp, $sName), $mArgs);
                break;

            case method_exists($this->_oTpl, $sName):
                return call_user_func_array(array($this->_oTpl, $sName), $mArgs);
                break;

            case method_exists($this->_oRoute, $sName):
                return call_user_func_array(array($this->_oRoute, $sName), $mArgs);
                break;

            default:

                $this->uses($sName);

                if (class_exists($sName)) {
                    $object = new ReflectionClass($sName);

                    if (!empty($mArgs)) {
                        return $object->newInstanceArgs($mArgs);
                    }
                    return $object->newInstance();
                }
                break;
        }

    } // __call


    public function __get($sName)
    {
        switch ($sName) {
            // Router
            case 'route':
                return $this->_oRoute;

            case 'global':
            case 'globals':
                return $GLOBALS;

            // tpl
            case 'tpls':
            case 'tpl':
                return $this->_oTpl;

            // Database
            case 'db':
                return $this->_oDB;

            // Config
            case 'config':
                return $this->_oConfig;

            // Cache
            case 'cache':
                //return $this->_oCache;
                break;

            default:
                return $this->_oTpl->{$sName};
        }
    } // __get


    public function __set($sName, $mValue)
    {
        switch ($sName) {
            case 'error':
                $this->_oTpl->error = $mValue;
                break;

            default:
                $this->_oTpl->{$sName} = $mValue;
        }
    } // __set


    public static function inject_once($mFiles = null)
    {
        if (empty($mFiles)) {
            dd::notice('empty file');
        }

        $sFilename = str_replace(
                array('kohana_', 'classes_', 'c_', 'adapters_', 'a_', 'ctrl_', 'm_'),
                array(CLASSES . DS . 'kohana' . DS, CLASSES . DS, CLASSES . DS, ADAPTERS . DS, ADAPTERS . DS, CTRL . DS, MODELS . DS . 'm_'),
                $mFiles
            ) . PHP;

        switch (true) {
            //This function
            case (is_file($sFilename)):
                include_once $sFilename;
                break;

            case (is_file(ROOT_DIR . DS . $sFilename)):
                include_once ROOT_DIR . DS . $sFilename;
                break;

            case (is_file(ARX_DIR . DS . $sFilename)):
                include_once ARX_DIR . DS . $sFilename;
                break;

            default:
                include_once $mFiles;
        }
    } // inject_once


    public static function injects_once($mArray)
    {
        try {
            $aFiles = u::toArray($mArray);

            if (is_array($aFiles)) {
                foreach ($aFiles as $file) {
                    self::inject_once($file);
                }
            } else {
                self::inject_once($mArray);
            }
        } catch (Exception $e) {
            die($e);
        }
    } // injects_once


    public static function needs()
    {
        $aArgs = func_get_args();
        $aRes = array();
        $aErr = array();

        foreach ($aArgs as $key => $value) {
            // Check if a constant is defined (in UPPERCASE)
            if (strtoupper($value) == $value && defined($value)) {
                $aRes[] = constant($value);
            } elseif (isset($_GLOBALS['aConfig'][$value])) {
                $aRes[] = $_GLOBALS['aConfig'][$value];
            } else {
                $aErr[] = $value;
            }
        }

        if (count($aErr)) {

        } else {
            return $aRes;
        }
    } // needs


    public static function uses($mFiles)
    {
        self::injects_once($mFiles);
    } // uses


    /**
     * requireaConfig
     * force a class to check if a global config is defined
     */
    public static function requireConfig($mValues)
    {
        $aValues = u::toarray($mValues);

        $aUndefinedVars = array();

        foreach ($aValues as $key => $value) {
            if (!isset($GLOBALS[$key])) {
                $aUndefinedVars[] = $key;
            }
        }

        if (!empty($aUndefinedVars)) {
            c_debug::warning('Missing configuration', $aUndefinedVars);
        }
    } // requireaConfig


    /**
     * Require Composer little script
     * @param  [type] $mValues [description]
     * @return [type]          [description]
     */
    public static function requireComposer($name, $version, $opts = array())
    {
        #1 get composer json
        $oComposer = file_get_contents(ROOT_DIR . DS . 'composer.json');

        predie($oComposer);
    }

} // class::arx


// --- AUTOLOAD REGISTER

if (!function_exists('arx_autoload')) {

    function arx_autoload($className)
    {

        $aAlias = array(
            "c_" => "/classes/",
            "a_" => "/adapters/",
            "i_" => "/interfaces/",
            "h_" => "/helpers/",
            "Arx\\" => ARX_DIR
        );

        $classPath = u::strAReplace($aAlias, $className) . PHP;

        if (is_file($classPath)) {
            include $classPath;
        }

    } // arx_autoload

}

//if class is not found => call this function
spl_autoload_register('arx_autoload');

// Application Hook looks for every additionnal scripts to load in apps (by default load all appFiles
// in DIR_APPS . APPS /inc/xxx.load.php, /css/xxx.load.css, /js/xxx.load.php)
\Arx\c_hook::preload();