<?php

use Arx\classes\Bag;

/**
 * Class HookTest
 */
class BagTest extends PHPUnit_Framework_TestCase {


	public function testBag(){

		$object = json_decode( '{"test":"test"}' );

		$bag = new Bag(array(
			'bool' => true,
			'string' => 'string',
			'int' => 123,
			'array' => array(
				'test'
			),
			'object' => $object
		));

		$this->assertTrue($bag['bool'], 'Not a bool');

		$this->assertTrue( is_string( $bag['string'] ), 'Not a string' );
	}



}
 