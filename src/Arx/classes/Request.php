<?php namespace Arx\classes;

use Arx;

/**
 * Class Request
 *
 * Request mockup for testing
 *
 * @package Arx\classes
 */
class Request {

	public static function __callStatic($name, $args){
		$app = Arx::getInstance()['request'];
		return call_user_func_array(array($app, $name), $args);
	}

	public function onlyNotEmpty($array){
		return $this->only(array_filter($array));
	}
}
