<?php namespace Arx\classes;

/**
 * Helper.php.
 *
 * @project : arx
 * @author : Daniel Sum <daniel@cherrypulp.com>
 */
abstract class Helper extends Container {

	public $data = [];

	/**
	 * @param array $data
	 */
	public function __construct($data = array())
	{
		$this->data = array_merge($this->data, get_defined_vars());

		return $this->data;
	}
}