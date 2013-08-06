<?php
// --- Aliases configuration

return array(
    'classes' => array(
        'u' => '\Arx\classes\Utils',
        'Route' => '\Arx\facades\Route'
    ),
    'functions' => array(
        'arxConfig' => '\Arx\classes\Config::instance',
        'getConfig' => '\Arx\classes\Config::get',
        'setConfig' => '\Arx\classes\Config::set',
        'predie' => '\Arx\classes\Utils::predie',
        'pre' => '\Arx\classes\Utils::pre',
        'k' => '\Arx\classes\Utils::k',
    ),
);
