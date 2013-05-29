<?php namespace Arx\Core\classes;

use Illuminate\Support\Facades\Config as ExtendedConfig;

class Config extends ExtendedConfig {

    private $_aDatas = array();

    public function __get( $sName )
    {
        if (array_key_exists( $sName, $this->_aDatas ))
            return $this->_aDatas[ $sName ];

        return null;
    } // __get

    public function __set( $sName, $mValue )
    {
        $this->_aDatas[ $sName ] = $mValue;
    } // __set

    public function __isset( $sName )
    {
        return isset($this->_aDatas[ $sName ]);
    } // __isset

    public function __unset( $sName )
    {
        unset($this->_aDatas[ $sName ]);
    } // __unset

    public function apply( $aValues )
    {
        $this->_aDatas = array_merge( $this->_aDatas, $aValues );

        return $this->_aDatas;
    } // apply

    public static function load( $sPath = null )
    {

        if(!$sPath){
            return include ARX_DIR.DS.'config'.DS.'default.php';
        }

        if(is_file($sPath)){
            return include $sPath;
        } else {

        }

    }

}
