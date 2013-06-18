<?php

/*
|--------------------------------------------------------------------------
| Register The Composer Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader
| for our application. We just need to utilize it! We'll require it
| into the script here so that we do not have to worry about the
| loading of any our classes "manually". Feels great to relax.
|
*/

require_once __DIR__.'/vendor/autoload.php';

/**
 * aConfig for Arx
 *
 * @author Daniel Sum <daniel@cherrylabs.net>
 * @link http://www.cherrylabs.net
 * @copyright Copyright &copy; 2010-2012 cherrylabs.net
 * @license http://www.cherrylabs.net/licence
 * @package arx
 * @since 1.0
 */

/*=======================================
=            GLOBALS CONFIG            =
=======================================*/

# variables that need to be accessible from anywhere and can potentially change or be a scalable variable

global $arxConfig;

$arxConfig = array(

    'project' => array(
        'title' => '',
        'licence' => '',
        'url' => '',
        'authors' => array(
            "Daniel Sum" => 'daniel@cherrypulp.com',
            "Stephan Zych" => 'stephan@cherrypulp.com',
        ),
    ),

    // System
    'system' => array(
        'app' => 'Arx\c_app',
        'route' => 'Arx\c_route',
        'template' => 'Arx\c_template',
        'auth' => 'Arx\c_auth',
        'db' => 'Arx\c_db'
    ),

    // Database
    'database' => array(
        'driver' => 'sqlite', // mysql | sqlite
        'database' => '/files/db.sqlite', // database name || database filepath
        'username' => '',
        'password' => '',
        'host' => '',
        'charset' => 'utf8',
        'prefix' => '',
    ),

    // Site
    'langs' => array(
        array('en' => 'English'),
        array('fr' => 'Français')
    ),

    // Mail
    'mail' => array(

    )
);

/*-----  End of GLOABALS CONFIG  ------*/

/*=========================================
=            Middleware CONFIG            =
=========================================*/

# variables that change depending the staging (feel free to adapt to your need)

define('ZE_ENV', 'loc');
define('LEVEL_ENV', 0);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

/*-----  End of Middleware CONFIG  ------*/

/*=======================================
=            CONSTANT CONFIG            =
=======================================*/

define('ZE_LANG', 'en'); // default language
define('ZE_LANGS', json_encode($arxConfig['langs']));

define('ZE_SALT', 'hp[2d`I2+Z>[5l]@)q`.vc^X[DUcPIH8gY07#R}DL)L+NjwJ(1q0%C/!C)lpjc,T'); // https://api.wordpress.org/secret-key/1.1/salt/
define('ZE_ALGO', 'sha1'); //sha1, sha256, md5 allowed
define('ZE_ADMINLOGIN', 'admin');
define('ZE_ADMINPWD', 'admin');

/*-----  End of CONSTANT CONFIG  ------*/

return $arxConfig;

/*
|--------------------------------------------------------------------------
| Set The Default Timezone
|--------------------------------------------------------------------------
|
| Here we will set the default timezone for PHP. PHP is notoriously mean
| if the timezone is not explicitly set. This will be used by each of
| the PHP date and date-time functions throughout the application.
|
*/

//Setting $_SERVER

$_SERVER['REQUEST_METHOD'] = "GET";

date_default_timezone_set('UTC');