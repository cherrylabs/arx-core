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

if ( ! function_exists('\notify'))
{
    /**
     * @param null $message
     * @param string $type
     *
     * @return Arx\classes\Notify
     */
    function notify($message = null, $type = 'info'){
        $notify = app('notify');

        if (is_string($message)) {
            return $notify->{$type}($message);
        } elseif (is_array($message)) {

            if (!is_array($type)) {
                $type = [
                    'type' => $type
                ];
            }

            return $notify->set($message, $type);
        }
        return $notify;
    }
}
