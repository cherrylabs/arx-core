<?php
/**
 * Helper loader and debug functions
 */

if ( ! function_exists('\ddd'))
{
    function ddd(){
        return call_user_func_array('Arx\classes\Utils::predie', func_get_args());
    }
}

if ( ! function_exists('\d'))
{
    function d(){
        return call_user_func_array('Arx\classes\Utils::pre', func_get_args());
    }
}

if ( ! function_exists('\de'))
{
    function de(){
        return call_user_func_array('Arx\classes\Utils::predie', func_get_args());
    }
}

if ( ! function_exists('\k'))
{
    function k(){
        return call_user_func_array('Arx\classes\Utils::k', func_get_args());
    }
}
