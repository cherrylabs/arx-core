<?php
/**
 * Config file
 *
 * @package     87seconds
 * @author      Daniel Sum
 * @link        @endlink
 * @see
 * @description
 *
 * @todo
 * - cleaning the config file
 */


// --- Before `aConfig.php` inclusion

if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) {
  define( 'IS_HTTPS', true);
}

define('HTTP', 'http'.(defined('IS_HTTPS') ? 's' : '').'://');
define('URL_ROOT', HTTP.$_SERVER['HTTP_HOST'].str_replace($_SERVER['DOCUMENT_ROOT'], '', dirname(dirname(__FILE__))));

define('DIR_FILE', str_replace('//', '/' , $_SERVER['DOCUMENT_ROOT'].$_SERVER['REQUEST_URI']));
define('URL_FILE', URL_ROOT.$_SERVER['REQUEST_URI']);

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

define('EXT_PHP', PHP);

define('ZE_DEBUG', 'ZE_DEBUG');


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

define('DIR_ROOT', dirname(dirname(__FILE__)));

define('ROOT_ADMIN', DIR_ROOT.DS.ADMIN);
define('DIR_APPS', DIR_ROOT.DS.APPS);
define('DIR_CSS', DIR_ROOT.DS.CSS);
define('DIR_JS', DIR_ROOT.DS.JS);
define('DIR_INC', DIR_ROOT.DS.INC);
define('DIR_LIBS', DIR_ROOT.DS.LIBS);

define('DIR_MODELS', DIR_ROOT.DS.MODELS);
define('DIR_VIEWS', DIR_ROOT.DS.VIEWS);
define('DIR_CTRL', DIR_ROOT.DS.CTRL);

define('DIR_ARX', DIR_ROOT.DS.ARX);

define('DIR_CLASSES', DIR_ARX.DS.CLASSES);
define('DIR_ADAPTERS', DIR_ARX.DS.ADAPTERS);
define('DIR_HELPERS', DIR_ARX.DS.HELPERS);
define('DIR_VENDOR', DIR_ROOT.DS.VENDOR);

define('ARX_CLASSES', DIR_ARX.DS.CLASSES);
define('ARX_ADAPTERS', DIR_ARX.DS.ADAPTERS);
define('ARX_VIEWS', DIR_ARX.DS.VIEWS);
define('ARX_LIBS', DIR_ARX.DS.LIBS);
define('ARX_HELPERS', DIR_ARX.DS.HELPERS);
define('ARX_CSS', URL_ROOT.DS.ARX.DS.LIBS.DS.CSS);
define('ARX_JS', URL_ROOT.DS.ARX.DS.LIBS.DS.JS);
define('ARX_INC', ARX_LIBS.DS.INC);

define('LIBS_CSS', ARX_CSS);
define('LIBS_JS', ARX_JS);
define('LIBS_INC', ARX_LIBS.DS.INC);

define('HOOK', 'arx_hook'); // default arx hook name

define('SYSPATH', DIR_CLASSES); // needed for Kohana


// --- `aConfig.php` inlusion

require_once dirname(dirname(__FILE__)).'/aConfig.php';


// --- After `aConfig.php` inclusion

if (defined('WEB_ROOT')) {
    // do something...
}
