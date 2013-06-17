<?php

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

return array(

    'project' => array(
        'title' => '{{title}}',
        'licence' => '{{licence}}',
        'url' => '{{YOUR URL}}',
        'authors' => array(
            "{{YOUR NAME}}" => '{{YOUR EMAIL}}'
        ),
    ),

    // System
    'system' => array(
        'orm' => 'a_idiorm', // ORM used
        'tpl' => 'a_savant3', // template engine used
        'route' => 'a_slim', // routing system used
        'auth' => 'c_auth', // Auth couch
    ),

    // Database
    'database' => array(
        'driver' => '{{sqlite}}', // mysql | sqlite
        'database' => '{{database}}', // database name || database filepath
        'username' => '{{username}}',
        'password' => '{{password}}',
        'host' => '{{host}}',
        'charset' => '{{utf8}}',
        'prefix' => '',
    ),

    // Site
    'langs' => array(
        'en' => '{{English}}'
    ),

    // Mail
    'mail' => array(
        'ssl' => false,
        'type' => '', //smtp|default
        'port' => '',
        'host' => '',
        'login' => '',
        'password' => '',
        'email' => '',
        'name' => ''
    )
);