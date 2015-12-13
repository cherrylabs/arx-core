<?php namespace Arx;

/**
 * Contract for an ApiService adapter
 *
 * Describing what method should have an Api Service at least
 *
 * @package Arx
 */
interface ApiInterface {

    /**
     * Api should have a basic call methods at least
     *
     * @param $endpoint
     * @param array $params
     * @param string $method
     * @return mixed
     * @internal param $search
     * @internal param array $param
     *
     */
    public function call($endpoint, $params = array(), $method = 'GET');

}