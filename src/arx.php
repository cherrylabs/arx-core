<?php
/**
 * Arx  - Entry point
 * PHP File - /arx.php
 */

namespace Arx;


define('ARX_VERSION', '0.1');


require_once __DIR__.DIRECTORY_SEPARATOR.'config.php';

require_once __DIR__.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'utils.php';
require_once __DIR__.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'singleton.php';
require_once __DIR__.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'config.php';
require_once __DIR__.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'load.php';
require_once __DIR__.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'hook.php';
require_once __DIR__.DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'filemanager.php';
