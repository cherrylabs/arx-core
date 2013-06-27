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


class Core extends Singleton
{

    // --- Constants

    const VERSION = '1.0';
    const CODENAME = 'Lupa';


    // --- Magic methods

    /**
     * Magic constructor by default load default config
     */
    public function __construct($mConfig = null) {} // __construct


    public function __call($sName, $aArgs) {} // __call


    public function __callStatic($sName, $aArgs) {} // __callStatic


    public function __get($sName) {} // __get


    public function __set($sName, $mValue) {} // __set


    // --- Public methods



    // --- Private members

    private $_defaults = array();
    private $_settings = array();

    private $_cache = null;
    private $_orm = null;
    private $_route = null;
    private $_template = null;

} // class::Core
