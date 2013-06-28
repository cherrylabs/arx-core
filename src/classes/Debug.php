<?php namespace Arx\classes;

class Debug {


    public function notice($error_msg, $error_type = "E_USER_NOTICE")
    {
        trigger_error($error_msg, $error_type);
    }

    /**
     * @param $error_msg
     * @param $error_type
     * @todo more complexe error tracing
     */
    public function error($error_msg, $error_type){
       trigger_error($error_msg, $error_type);
    }
}