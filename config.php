<?php
/**
 * Minimal config file for the Arx Core
 */

@include_once(getenv('DOCUMENT_ROOT') . DIRECTORY_SEPARATOR . 'arxConfig.php');



// --- Before `aConfig.php` inclusion

if (!defined('IS_HTTPS') && !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || getenv('SERVER_PORT') == 443) {
    define('IS_HTTPS', true);
}

if (!defined('HTTP'))
    define('HTTP', 'http' . (defined('IS_HTTPS') ? 's' : '') . '://');

if (!defined('ROOT_DIR'))
    define('ROOT_DIR', getenv('DOCUMENT_ROOT'));

if (!defined('ROOT_URL')){
    define('ROOT_URL', HTTP . getenv('HTTP_HOST') . str_replace(getenv('DOCUMENT_ROOT'), '', dirname(dirname(__FILE__))));
}

if (!defined('FILE_DIR'))
    define('FILE_DIR', str_replace('//', '/', getenv('DOCUMENT_ROOT') . getenv('REQUEST_URI')));

if (!defined('FILE_URL'))
    define('FILE_URL', ROOT_URL . getenv('REQUEST_URI'));

if (!defined('DS'))
    define('DS', '/');

if (!defined('PHP'))
    define('PHP', '.php');

if (!defined('CTL'))
    define('CTL', '.php');

if (!defined('TPL'))
    define('TPL', '.tpl');

// --- Prefix

define('CTRL_', 'ctrl_');
define('M_', 'm_');
define('C_', 'c_');
define('A_', 'a_');
define('I_', 'i_');
define('H_', 'h_');

// --- Paths configuration

define('CSS', 'css');
define('JS', 'js');
define('IMG', 'img');
define('INC', 'inc');
define('LIBS', 'assets');
define('APPS', 'apps');
define('ADMIN', 'arxmin');
define('MODELS', 'models');
define('VIEWS', 'views');
define('CTRL', 'controllers');
define('ARX', 'arx');
define('CLASSES', 'classes');
define('ADAPTERS', 'adapters');
define('VENDOR', 'vendor');
define('HELPERS', 'helpers');

if(!defined('ARX_DIR'))
    define('ARX_DIR', dirname(__FILE__));

if(!defined('SYSPATH'))
    define('SYSPATH', dirname(__FILE__));

define('ARX_CLASSES', ARX_DIR . DS . CLASSES);
define('ARX_ADAPTERS', ARX_DIR . DS . ADAPTERS);
define('ARX_VIEWS', ARX_DIR . DS . VIEWS);
define('ARX_LIBS', ARX_DIR . DS . LIBS);
define('ARX_HELPERS', ARX_DIR . DS . HELPERS);
define('ARX_CSS', ROOT_URL . DS . ARX . DS . LIBS . DS . CSS);
define('ARX_JS', ROOT_URL . DS . ARX . DS . LIBS . DS . JS);

//  --- Default arx shorcut
define('ARX_HOOK', 'arx_hook');
define('ZE_DEBUG', 'ZE_DEBUG');