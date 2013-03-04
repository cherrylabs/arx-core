<?php defined('SYSPATH') or die('No direct script access.');

class c_model extends Arx
{   
    public function __construct( $mConfig = array() ){
        
        parent::__construct($mConfig);

    }

    public static function __callStatic($name, $arguments)
    {
        $class = explode('_', $name);

        return call_user_func_array($aClass, $arguments);
    }

    public function checkEmail($mData){
        if (is_string($mData)) {
            return u::checkEmail($mData);
        } elseif (is_array($mData)) {
            return u::checkEmail($mData['email']);
        } elseif (is_object($mData)) {
            return u::checkEmail($mData->email);
        }

        return false;
    }

    public function encode($str){
        return base64_encode($str);
    }

    public function decode($str){
        return base64_decode($str);
    }

    public function crypt($str){
        return hash( ZE_ALGO, ZE_SALT.$str );
    }

    public function cryptCheck($uncrypted, $crypted){
        return self::crypt($uncrypted) === $crypted ? true : false;
    }

	/**
     * Trigger an event and call its observers
     */
    public function trigger($event, $data = FALSE)
    {
        if (isset($this->$event) && is_array($this->$event))
        {
            foreach ($this->$event as $method)
            {
                if (strpos($method, '('))
                {
                    preg_match('/([a-zA-Z0-9\_\-]+)(\(([a-zA-Z0-9\_\-\., ]+)\))?/', $method, $matches);

                    $method = $matches[1];
                    $this->callback_parameters = explode(',', $matches[3]);
                }

                $data = call_user_func_array(array($this, $method), array($data));
            }
        }
        
        return $data;
    }

    /**
     * Get the table object var $table must be defined !
     * @return object orm object
     * @todo better rules
     */
    public function table($name){

    	return a_db::table($name);
    }
}
