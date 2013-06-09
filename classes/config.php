<?php namespace Arx;

use Symfony\Component\Finder\Finder;

class c_config extends c_singleton {

    public $_aData = array();

    private static $sDefault = 'default';

    public function __get( $sName )
    {
        if (array_key_exists( $sName, $this->_aData ))
            return $this->_aData[ $sName ];

        return null;
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

            $data = include ARX_DIR.DS.'config'.DS.'default.php';

            if(isset($GLOBALS['arxConfig'])){
                $data = array_merge($GLOBALS['arxConfig'], $data);
            }

            $t->_aData['ze_env'] = ZE_ENV;

        } elseif(is_file($sPath)){
            $data = include $sPath;
        }

        if(!empty($data)){

            $t->set($sPath, $data);

            return $data;
        }

        return false;

    }

    public static function set($sName, $data){
        $object = self::getInstance();
        $object->_aData[$sName] = $data;
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

        if(!$object->isLoaded){
            $object->load();
        }

        $aPart = explode('.', $name);
        $iPart = count($aPart);

        $data = $object->data();

        $env = $data['ze_env'];

        if(!empty( $data[$env]) ){
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
        }

    }

}
