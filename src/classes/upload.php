<?php defined('SYSPATH') or die('No direct script access.');

class c_upload extends Kohana_Upload {
    
    public function __construct()
    {
        
    }

    public function clean($files){
    	
    	$aCleaned = array();

    	foreach ($files as $key => $value) {
			if(isset($value['name']) && !isset($value['name'][0])){
				$currentName = isset($filename[$key]) ? $filename[$key] : null;
				$aCleaned[$key] = $value;

			} else {
				$aSubCleaned = u::array_diverse($value);
				foreach ($aSubCleaned as $key2 => $value2) {
					$aCleaned[$key.'_'.$key2] = $value2;
				}
			}
		}

		return $aCleaned;

    }

    public function saveMultiple($files, $filename = NULL, $directory = NULL, $chmod = 0644){

    	if (isset($files['name'])) {
    		return self::save($files, $filename, $directory, $chmod);
    	} else {
    		foreach ($files as $key => $value) {
    			if(isset($value['name']) && !isset($value['name'][0])){

    				$currentName = isset($filename[$key]) ? $filename[$key] : null;
    				self::save($value, $currentName, $directory, $chmod);

    			} else {
    				$aCleaned = u::array_diverse($value);

    				foreach ($aCleaned as $key2 => $value2) {
    					$currentName = isset($filename[$key]) ? $key2.$filename[$key] : null;
    					self::save($value2, $currentName, $directory, $chmod);
    				}
    			}
    		}
    	}

    	return false;

    }
}

class Upload extends c_upload{}