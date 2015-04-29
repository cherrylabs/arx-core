<?php namespace Arx;

use Arx\classes\Helper;
use Arx\classes\Arr;

/**
 * Class InvoiceHelper
 *
 * Little invoice helper
 */
class InvoiceHelper extends Helper implements \ArrayAccess {

    public $data;

    public static $_default = [
            'header' => '',
            'title_left' => ' ',
            'title_right' => '',
            'block_left' => [],
            'block_right' => [],
            'body_title' => '',
            'table_header' => [],
            'table' => [],
            'table_footer' => [],
            'footer' => ""
    ];

    public function __construct($data = array())
    {
        $defData = Arr::merge(self::$_default, [
            'header' => ""
        ]);

        $this->data = Arr::merge($defData, $data);
    }

    public function offsetExists($offset){
        return isset($this->data[$offset]);
    }


    public function offsetGet($offset){
        return $this->data[$offset];
    }


    public function offsetSet($offset, $value){
        $this->data[$offset] = $value;
    }


    public function offsetUnset($offset){
        unset($this->data[$offset]);
    }


    public function toArray(){
        return $this->data;
    }
}