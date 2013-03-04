<?php

class c_apps
{
    public function __construct()
    {
        $arg = func_get_args();

        foreach ($arg as $key=>$value) {
            $this->{$key} = $value;
        }

        $this->filepath = str_replace(array(DIR_ROOT,'manifest'.EXT_PHP), '', $_SERVER['SCRIPT_FILENAME']);
    }

    public function __set($key, $value)
    {
        $this->{$key} = $value;
    }

    public function output($type = "array", $method = null)
    {
        switch ($type) {
            case "array":
                return $this->return_array();
            break;

            default:
                die($this->return_json());
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
