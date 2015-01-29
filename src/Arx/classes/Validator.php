<?php namespace Arx\classes;

/**
 * Class Validator
 */
class Validator {

	/**
	 * Validator outside Laravel
	 *
	 * @param $name
	 * @param $args
	 * @return mixed
	 */
	public static function __callStatic($name, $args){
		$filesystem = new \Illuminate\Filesystem\Filesystem();
		$loader = new \Illuminate\Translation\FileLoader($filesystem, \Arx::path('../lang/'));
		$translator = new \Illuminate\Translation\Translator($loader, 'en');
		$app = new \Illuminate\Validation\Factory($translator);
		return call_user_func_array(array($app, $name), $args);
	}
}