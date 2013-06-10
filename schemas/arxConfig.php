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
        'title' => {arx},
        'licence' => 'Cherrypulp',
        'url' => 'http://www.aquascope.be',
        'authors' => array(
            "Daniel Sum" => 'daniel@cherrypulp.com',
            "Stephan Zych" => 'stephan@cherrypulp.com',
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
        'driver' => 'mysql', // mysql | sqlite
        'database' => 'aquascop', // database name || database filepath
        'username' => 'aquascop',
        'password' => 'nQcqgvGj',
        'host' => '2host.it',
        'charset' => 'utf8',
        'prefix' => '',
    ),

    // Site
    'langs' => array(
        'fr' => 'French'
    ),

    // Mail
    'mail' => array(
        'ssl' => true,
        'type' => 'smtp', //smtp|default
        'port' => 25,
        'host' => 'in.mailjet.com',
        'login' => '3424a1003485e64aca37251a200bdfce',
        'password' => 'a743e52303b6ae20920b728eb156a8bd',
        'email' => 'aquascope@in.mailjet.com',
        'name' => 'Aquascope'
    )
);