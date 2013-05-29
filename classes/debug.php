<?php defined('SYSPATH') or die('No direct script access.');
/**
 * DEBUG CLASS
 */
require_once ARX_INC.DS.'FirePHPCore'.DS.'fb'.PHP;

if(LEVEL_ENV > 1)   FB::setEnabled(false);

class c_debug extends FB
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

}

class dd extends c_debug{}