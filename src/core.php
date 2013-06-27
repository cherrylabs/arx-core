<?php namespace Arx;
/**
 * Arx  - Entry point
 * PHP File - /arx.php
 */


if (!defined('IS_HTTPS') && !empty(getenv('HTTPS')) && getenv('HTTPS') !== 'off' || getenv('SERVER_PORT') == 443) {
    define('IS_HTTPS', true);
}

defined('HTTP') or define('HTTP', 'http'.(defined('IS_HTTPS') ? 's' : '') . '://');

defined('DS') or define('DS', DIRECTORY_SEPARATOR);


<<<<<<< HEAD:src/core.php
require_once __DIR__.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'utils.php';
require_once __DIR__.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'singleton.php';
require_once __DIR__.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'config.php';
require_once __DIR__.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'load.php';
require_once __DIR__.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'hook.php';
require_once __DIR__.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'arx.php';
=======
require_once __DIR__.DS.'classes'.DS.'singleton.php';
require_once __DIR__.DS.'classes'.DS.'utils.php';
require_once __DIR__.DS.'classes'.DS.'config.php';
require_once __DIR__.DS.'classes'.DS.'arx.php';
>>>>>>> dfe2615c121e53eb107667e31362383da9914387:src/arx.php
