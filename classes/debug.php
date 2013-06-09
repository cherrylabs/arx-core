<?php namespace Arx;

/**
 * DEBUG CLASS
 */

use \Symfony\Component\Debug\Debug;

class c_debug extends Debug
{
    public $_output;

    public static function get_info()
    {
        return $GLOBALS['c_debug']['info'];

    }

    public static function notice($msg)
    {

        $GLOBALS['c_debug']['notice'] = $msg;

        //trigger_error($msg . ' in file '.$file. ' @ line '.$line, E_USER_NOTICE);

    }

    /**
     * Mode debugger
     * @return [type] [description]
     */
    public static function mode()
    {
        $aArgs = func_get_args();
        $iArgs = func_num_args();

        switch (true) {
            case $iArgs == 1 && is_bool($aArgs[0]):
                    $_GET['c_debug'] = true;
                    $GLOBALS['c_debug']['level'] = 1;

                    return true;
            break;

            default:
                if ($_GET['c_debug'] == true && ZE_ENV <= $GLOBALS['c_debug']['level']) {
                    return true;
                } else {
                    return false;
                }
                break;
        }

    }

    public static function info($msg)
    {
        $GLOBALS['c_debug']['info'] = $msg;
    }

    public static function warning($msg){
        trigger_error($msg, 'WARNING');
    }

}