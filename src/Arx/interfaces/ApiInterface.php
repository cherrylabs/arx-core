<?php namespace Arx;

interface ApiInterface {

	/**
	 * Api should have a basic call methods
	 *
	 * @param $search
	 * @param array $param
	 *
	 * @return mixed
	 */
    public function call($endpoint, $param = array(), $method = 'GET');

}