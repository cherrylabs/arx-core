<?php

/**
 * PHP File - /core.php
 *
 * The MIT License (MIT)
 *
 * Copyright (c) <year> <copyright holders>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @category Kit
 * @package  Arx
 * @author   Daniel Sum <daniel@cherrypulp.com>
 * @author   Stéphan Zych <stephan@cherrypulp.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @link     http://arx.xxx
 */

/**
 * Constant declarations
 */
defined('ARX_STARTTIME') or define('ARX_STARTTIME', microtime(true));
defined('IS_HTTPS') or define('IS_HTTPS', true);
defined('HTTP') or define('HTTP', 'http' . (defined('IS_HTTPS') ? 's' : '') . '://');
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

/**
 * These classes are needed for basic manipulation
 */
require_once __DIR__ . DS . 'classes' . DS . 'Singleton.php';
require_once __DIR__ . DS . 'classes' . DS . 'Container.php';
require_once __DIR__ . DS . 'classes' . DS . 'Arr.php';
require_once __DIR__ . DS . 'classes' . DS . 'Strings.php';
require_once __DIR__ . DS . 'classes' . DS . 'Utils.php';

/**
 * Composer class to helping to manage Namespace and Class (need to be relative)
 */
require_once 'classes/Composer.php';

/**
 * Classes that needs to be include and can't be include with autoload
 */
require_once __DIR__ . DS . 'classes' . DS . 'Asset.php';
require_once __DIR__ . DS . 'classes' . DS . 'Cache.php';
require_once __DIR__ . DS . 'classes' . DS . 'Convert.php';
require_once __DIR__ . DS . 'classes' . DS . 'Date.php';
require_once __DIR__ . DS . 'classes' . DS . 'Debug.php';
require_once __DIR__ . DS . 'classes' . DS . 'Finder.php';
require_once __DIR__ . DS . 'classes' . DS . 'Globals.php';
require_once __DIR__ . DS . 'classes' . DS . 'Hook.php';
require_once __DIR__ . DS . 'classes' . DS . 'Orm.php';
require_once __DIR__ . DS . 'classes' . DS . 'Route.php';
require_once __DIR__ . DS . 'classes' . DS . 'Valid.php';
require_once __DIR__ . DS . 'classes' . DS . 'Config.php';
require_once __DIR__ . DS . 'classes' . DS . 'App.php';

class Arx extends \Arx\classes\App{}

spl_autoload_register('Arx::autoload');
