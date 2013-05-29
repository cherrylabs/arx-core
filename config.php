<?php
/**
 * Minimal config file for the Arx Core
 */


// --- Before `aConfig.php` inclusion

if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || getenv('SERVER_PORT') == 443 ) {
  define( 'IS_HTTPS', true);
}

define('HTTP', 'http'.(defined('IS_HTTPS') ? 's' : '').'://');

define('ROOT_DIR', getenv('DOCUMENT_ROOT'));

define('ROOT_URL', HTTP.getenv('HTTP_HOST').str_replace(getenv('DOCUMENT_ROOT'), '', dirname(dirname(__FILE__))));

define('FILE_DIR', str_replace('//', '/' , getenv('DOCUMENT_ROOT').getenv('REQUEST_URI')));

define('FILE_URL', ROOT_URL.getenv('REQUEST_URI'));

define('DS', '/');

define('PHP', '.php');
define('CTL', '.php');
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
define('LIBS', 'libs');
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

define('ARX_DIR', dirname(__FILE__));

define('ARX_CLASSES', ARX_DIR.DS.CLASSES);
define('ARX_ADAPTERS', ARX_DIR.DS.ADAPTERS);
define('ARX_VIEWS', ARX_DIR.DS.VIEWS);
define('ARX_LIBS', ARX_DIR.DS.LIBS);
define('ARX_HELPERS', ARX_DIR.DS.HELPERS);
define('ARX_CSS', ROOT_URL.DS.ARX.DS.LIBS.DS.CSS);
define('ARX_JS', ROOT_URL.DS.ARX.DS.LIBS.DS.JS);

//  --- Default arx shorcut
define('ARX_HOOK', 'arx_hook');
define('ZE_DEBUG', 'ZE_DEBUG');