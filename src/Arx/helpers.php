<?php
/**
 * Helper loader for functions
 * @todo : better helper integrations via autoload functions
 */
use Arx\classes\Utils;

if ( ! function_exists('\predie'))
{
    function predie(){
        return call_user_func_array('Arx\classes\Utils::predie', func_get_args());
    }
}

if ( ! function_exists('\de'))
{
    function de(){
        return call_user_func_array('Arx\classes\Utils::de', func_get_args());
    }
}

if ( ! function_exists('\k'))
{
    function k(){
        return call_user_func_array('Arx\classes\Utils::k', func_get_args());
    }
}