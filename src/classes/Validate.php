<?php namespace Arx\classes;
/**
 * Arx
 * PHP File - /classes/Validate.php
 */


abstract class Validate {

    /**
     * Check if an email address is valid.
     *
     * Credit: http://codeigniter.com/user_guide/helpers/email_helper.html
     * License: http://codeigniter.com/user_guide/license.html
     *
     * @param   string
     * @return  bool
     */
    public static function is_valid_email($address) {
        return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $address)) ? false : true;
    } // is_valid_email

} // class::Validate
