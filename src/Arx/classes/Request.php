<?php namespace Arx\classes;

use Arx;

class Request {
	public static function __callStatic($name, $args){
		$app = Arx::getInstance()['request'];
		return call_user_func_array(array($app, $name), $args);
	}
}
