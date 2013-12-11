<?php
/**
 * Assets class fork of Fuel
 *
 * @package     Arx
 * @version     1.6
 * @author      Fuel Development Team
 * @author      Daniel Sum <daniel@cherrypulp.com>
 * @license     MIT License
 */

namespace Arx\classes;

use Assetic\Asset\AssetCollection;
use Assetic\Asset\FileAsset;
use Assetic\Asset\GlobAsset;
use Assetic\AssetManager;
use Assetic\Filter\LessFilter;
use Assetic\Filter\Yui;

/**
 * Class Asset
 *
 * Asset class based on Assetic class
 *
 * @package Arx\classes
 */
class Asset
{

    /**
     *
     * Dump an array of stylesheets or css
     *
     * @param       $mAsset
     * @param array $param (available
     *              'filters' => array(),
     *              'sourceRoot' => null,
     *              'vars' => array()
     * @see https://github.com/kriswallsmith/assetic for more informations about available params
     * @return string
     */
    public static function dump($mAsset, $param = array())
    {
        $aCleaned = self::format($mAsset, $param);

        $ac = new AssetCollection($aCleaned[0], $aCleaned[1], $aCleaned[2], $aCleaned[3]);

        return $ac->dump();
    }


    /**
     * Format array to the Assetic format
     *
     * @param       $mAsset
     * @param array $param
     *
     * @return array
     */
    public static function format($mAsset, $param = array())
    {

        $defParam = array(
            'filters' => array(),
            'sourceRoot' => Composer::getRootPath(),
            'vars' => array()
        );

        $aAssets = array();

        $param = array_merge($defParam, $param);

        if (is_string($mAsset)) {
            $mAsset = array($mAsset);
            $aAssets[] =  self::resolve($mAsset);
        } else {
            foreach ($mAsset as $asset) {
                $aAssets[] = self::resolve($asset);
            }
        }

        return $result = array($aAssets, $param['filters'], $param['sourceRoot'], $param['vars']);
    }

    /**
     * Resolve path according to the Assetic Asset
     *
     * @param $mVar
     *
     * @return object
     */
    public static function resolve($mVar)
    {
        if (is_string($mVar) && strpos($mVar, '*')) {
            $mVar = array($mVar);
            return Utils::call_user_obj_array('\Assetic\Asset\GlobAsset', $mVar);
        } elseif (is_array($mVar) && strpos($mVar[0], '*')) {
            return Utils::call_user_obj_array('\Assetic\Asset\GlobAsset', $mVar);
        } else {
            if(is_string($mVar)){
                $mVar = array($mVar);
            }
            return Utils::call_user_obj_array('\Assetic\Asset\FileAsset', $mVar);
        }
    }
}