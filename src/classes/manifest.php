<?php

class c_manifest
{
    public function __construct()
    {
        $arg = func_get_args();

        foreach ($arg as $key=>$value) {
            $this->{$key} = $value;
        }

        $this->filepath = str_replace(array(ROOT_DIR,'manifest'.PHP), '', $_SERVER['SCRIPT_FILENAME']);
    }

    public function __set($key, $value)
    {
        $this->{$key} = $value;
    }

    public function output($type = null, $method = null)
    {
        switch ($type) {
            case "array":
                return $this->return_array();
            break;

            default:
                echo $this->return_json();
            break;

        }
    }

    public function return_array()
    {
        return (get_object_vars($this));
    }

    public function return_json()
    {
        return json_encode($this->return_array());
    }
}
