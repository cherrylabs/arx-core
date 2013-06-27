<?php namespace Arx\classes;

include_once __DIR__ . '/object.php';

use Symfony\Component\Finder\Finder;

class Config extends Container {

    public $_aData = array();
    public $_clonable = false;
    public $_path = './config';

    private static $sDefault = 'default';

    public function __construct( $path = null ){
        if($path){
            die($path);
        }
    }

    public function __get( $sName )
    {
        if (array_key_exists( $sName, $this->_aData ))
            return $this->_aData[ $sName ];
        else
            return new Object();
    } // __get

    public function __set( $sName, $mValue )
    {
        $this->_aData[ $sName ] = $mValue;
    } // __set

    public function __isset( $sName )
    {
        return isset($this->_aData[ $sName ]);
    } // __isset

    public function __unset( $sName )
    {
        unset($this->_aData[ $sName ]);
    } // __unset

    public static function apply( $aValues )
    {
        $t = self::getInstance();

        $t->_aData = array_merge( $t->_aData, $aValues );

        return $t->_aData;
    } // apply

    public static function load( $sPath = null )
    {

        $t = self::getInstance();

        if(!$sPath){
            $sPath = $t->sDefault;

            $data = include_once ARX_DIR.DS.'config'.DS.'default.php';

            if(!is_array($data)){
                $data = array();
            }

            if(isset($GLOBALS['arxConfig'])){

                $data = array_merge($GLOBALS['arxConfig'], $data);
            }

        } elseif(is_file($sPath)){
            $data = include $sPath;
        }

        if(!empty($data)){

            return $data;
        }

        return false;

    }

    public static function set($sName = array(), $data, $persistent = false){

        $object = self::getInstance();

        switch (count($aArgs)) {
            case 1:
                $object->{$aArgs[0]} = $data;
                break;
            case 2:
                $object->{$aArgs[0]}->{$aArgs[1]} = $data;
                break;
            case 3:
                $object->_aData[$aArgs[0]][$aArgs[1]][$aArgs[2]] = $data;
                break;
            case 4:
                $object->_aData[$aArgs[0]][$aArgs[1]][$aArgs[2]][$aArgs[3]] = $data;
                break;
            case 5:
                $object->_aData[$aArgs[0]][$aArgs[1]][$aArgs[2]][$aArgs[3]][$aArgs[4]] = $data;
                break;

            default:
                $object->_aData[$sName] = $data;
                break;
        }
    }

    public static function data(){
        $t = self::getInstance();
        return $t->_aData;
    }

    public static function oData(){
        $t = self::getInstance();
        return u::arrayToObject($t->_aData);
    }

    public static function get($name, $default = null){
        $object = self::getInstance();

        /*if(!$object->isLoaded){
            $object->load();
        }

        $aPart = explode('.', $name);
        $iPart = count($aPart);

        $data = $object->data();

        if(!isset($env)){
            $env = "default";
        }

        if(isset($data[$env]) ){
            $aData = array_merge( $data[$object->sDefault], $data[$env]);
        } else {
            $aData = $data[$object->sDefault];
        }

        if($iPart == 1){
            return $aData[$aPart[0]];
        } elseif($iPart == 2) {
            return $aData[$aPart[0]][$aPart[1]];
        } elseif($iPart == 3) {
            return $aData[$aPart[0]][$aPart[1]][$aPart[2]];
        } elseif($iPart == 4) {
            return $aData[$aPart[0]][$aPart[1]][$aPart[2]][$aPart[3]];
        } elseif($iPart == 5) {
            return $aData[$aPart[0]][$aPart[1]][$aPart[2]][$aPart[3]][$aPart[4]];
        } else {
            return false;
        }*/

    }

}

class_alias('Arx\\classes\Config', 'c_config');
