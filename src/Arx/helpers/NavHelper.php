<?php namespace Arx;

use Arx\classes\Helper;

/**
 * Class Navigation Helper class
 *
 * @package Arx\helpers
 */
class NavHelper extends Helper {

    public $data = array();

    public function __construct($data = array())
    {

    }

    public function addItem($data, $postion = 'last')
    {
        $this->data[] = $data;

        return $this;
    }

    /**
     * Return nav as array
     *
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * Return nav as json
     *
     * @return string
     */
    public function toJson(){
        return json_encode($this->data);
    }
}