<?php namespace Arx\classes;
/**
 * ARX The refexive kit.
 *
 * PHP File - /classes/arx.php
 *
 * @description     Core File
 * @package         arx
 * @author          Daniel Sum, Stéphan Zych
 * @version         1.0
 */


class App extends Singleton
{

    // --- Constants

    const VERSION = '1.0';
    const CODENAME = 'Lupa';


    // --- Private members

    private $_cache = null;
    private $_config = null;
    private $_orm = null;
    private $_route = null;
    private $_template = null;


    // --- Constructor

    /**
     * Magic constructor by default load default config.
     *
     * @status      dev
     */
    public function __construct($mConfig = null) {
        $aFiles = glob(__DIR__.'/utils/*');

        foreach ($aFiles as $sFilePath) {
            require_once $sFilePath;
        }

        Config::load(__DIR__.'/../config/*', 'default');

        $this->_config = Config::getInstance();

        if (!is_null($mConfig)) {
            $system = Config::get('system');

            foreach ($system as $type => $class) {
                $path = Config::get('paths.adapters');

                if (end(explode(DS, $path)) !== '') {
                    $path .= DS;
                }

                Config::load($path.$class.'.php');

                $className = '\\App\\classes\\'.$type;

                if (class_exists($className)) {
                    $this->{'_'.$type} = new $className();
                }
            }
        }

        // ...

    } // __construct


    // --- Magic methods

    public function __call($sName, $aArgs) {} // __call


    public function __callStatic($sName, $aArgs) {} // __callStatic


    public function __get($sName) {} // __get


    public function __set($sName, $mValue) {} // __set


} // class::App
