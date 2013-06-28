<?php namespace Arx\classes;

/**
 * Validate
 * PHP File - /classes/Validate.php
 *
 * @category Utils
 * @package  Arx
 * @author   Daniel Sum <daniel@cherrypulp.com>
 * @author   Stéphan Zych <stephan@cherrypulp.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @link     http://arx.xxx/doc/Validate
 */
abstract class Validate
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
    public static function isValidEmail($address)
    {
        return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $address)) ? false : true;
    } // isValidEmail

} // class::Validate
