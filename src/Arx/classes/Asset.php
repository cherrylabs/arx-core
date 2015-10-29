<?php namespace Arx\classes;

use Arx;

/**
 * Class Assets
 *
 * Smarter assets handler
 *
 * @example
 *
 * Asset::js(['file1.js', 'file2.js]);
 *
 * #output
 *
 * <script type="text/javascript" src="file1.js"></script>
 * <script type="text/javascript" src="file2.js"></script>
 *
 * @package Arx\classes
 *
 */
class Asset extends singleton
{

    protected $_aInstances = array();

    public static function js($data = array(), $params = array(
        'compiled' => false,
        'attributes' => [],
        'secure' => false,
    ))
    {

        return Load::js($data, $params);
    }

    public static function css($data = array(), $params = array(
        'compiled' => false,
        'attributes' => [],
        'secure' => false,
    ))
    {
        return Load::css($data, $params);
    }

} 