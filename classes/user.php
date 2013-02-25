<?php
/**
 * An USER class
 * @file
 *
 * @package
 * @author Daniel Sum
 * @link 	@endlink
 * @see acl.php for more information
 * @description
 *
 * @code 	@endcode
 * @comments
 * @todo
 */

arx::uses('c_acl');

if(!$_SESSION)	session_start();

class c_user extends c_acl
{
    public $user;
    private $meta, $role;

    public static function help()
    {
        $h = new c_help();

        $h->output();
    }

    public function __construct()
    {
        parent::__construct();
    }

    public function destruct()
    {
        $_SESSION[ZE_USER] = "";

        return session_destroy();
    }

    public static function granted($sLogin = null, $sPassword = null)
    {
        switch (true) {
            case ($_SESSION[ZE_USER]):
                return true;
            break;
            case ($sLogin == ZE_ADMINLOGIN && $sPassword == ZE_ADMINPWD):
                $_SESSION[ZE_USER] = true;

                return true;
            break;

            case ( $id = self::login($sLogin, $sPassword) ):
                return $id;
            break;
        }

        return false;
    }

    public function grantOrKick($sKickUrl = null)
    {
        $a = func_get_args();
        if (is_int($a[0])) {
            if($_SESSION['ZE_USER']->level <= $a[0])

                return true;
            elseif($sKickUrl)
                header('Location:'.ZE_ADMINROOT);
            else
                header('Location:'.ZE_ADMINROOT);
        }
    }

    public function grantOrDeny($msg = null)
    {
        $a = func_get_args();
        if (is_int($a[0])) {
            if($_SESSION['ZE_USER']->level <= $a[0])

                return true;
            else
                return false;
        }

        return false;
    }

    public static function login($sLogin = null, $sPassword = null)
    {
        if(!$sLogin || !$sPassword)	return false;

        $_SESSION[ZE_USER] = a_db::findOne(T_USERS, "login = 'admin' AND password = 'admin'");

        if($_SESSION[ZE_USER])	return $_SESSION[ZE_USER];
        else return false;

    }

}

if (!class_exists('a_acl')) {
    class a_acl extends c_acl
    {
    }
}
