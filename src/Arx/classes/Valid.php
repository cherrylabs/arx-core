<?php namespace Arx\classes;

/**
 * Valid
 *
 * usefull validation pattern extension
 *
 * @category Utils
 * @package  Arx
 * @author   Daniel Sum <daniel@cherrypulp.com>
 * @author   Stéphan Zych <stephan@cherrypulp.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @link     http://arx.xxx/doc/Valid
 */
class Valid
{

    /**
     * Check if an email address is valid.
     *
     * Credit: http://codeigniter.com/user_guide/helpers/email_helper.html
     * License: http://codeigniter.com/user_guide/license.html
     *
     * @param string $address The email to validate
     *
     * @return bool
     */
    public static function isEmail($address)
    {
        return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $address)) ? false : true;
    } // isValidEmail


    public static function isJSON($str) {
       return json_decode($str) != null;
    } // isJSON


    public static function isMD5($str) {
       return (bool) preg_match('/^[0-9a-f]{32}$/i', $str);
    } // isMD5


    public static function isSHA1($str) {
       return (bool) preg_match('/^[0-9a-f]{40}$/i', $str);
    } // isSHA1


    public static function isSHA25($str) {
       return (bool) preg_match('/^[0-9a-f]{64}$/i', $str);
    } // isSHA25

} // class::Valid
