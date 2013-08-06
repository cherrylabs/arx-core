<?php
/**
 * Part of the Fuel framework.
 *
 * @package    Fuel
 * @version    1.6
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2013 Fuel Development Team
 * @link       http://fuelphp.com
 */

namespace Arx\classes;

use Assetic\Asset\AssetCollection;
use Assetic\Asset\FileAsset;
use Assetic\Asset\GlobAsset;
use Assetic\AssetManager;
use Assetic\Filter\LessFilter;
use Assetic\Filter\Yui;

/**
 * The Asset class allows you to easily work with your apps assets.
 * It allows you to specify multiple paths to be searched for the
 * assets.
 *
 * You can configure the paths by copying the core/config/asset.php
 * config file into your app/config folder and changing the settings.
 *
 * @package     Fuel
 * @subpackage  Core
 */
class Asset extends Singleton
{
    public static $css;
    public static $js;
    public static $img;
    public static $others = array();

    public function __construct(){

        static::$css = new AssetManager();

        static::$img = new AssetManager();

        static::$js = new AssetManager();
    }

    public static function __callStatic($name, $arguments){
        $instance = self::getInstance();
    }


}