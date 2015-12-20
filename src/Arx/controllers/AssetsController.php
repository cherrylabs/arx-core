<?php namespace Arx\controllers;

use Arx\classes\Convert;
use Assetic\Asset\FileAsset, Assetic\Asset\AssetCollection;
use Response, App, View, Arx\classes\Composer;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Class AssetsController
 *
 * Can resolve assets access when assets come from vendors or workbench or when you need to protect your assets from public
 *
 * @package Arx
 */
class AssetsController extends BaseController {

    /**
     * Path should be always relative to the root path
     *
     * @var string
     */
    public $_paths = array('workbench','vendor', 'app/assets');

    /**
     * @param array $parameters
     *
     * @return mixed|void
     */
    public function missingMethod($parameters = array())
    {

        if (is_array($parameters)) {
            $parameters = implode('/', $parameters);
        }

        # If parameters is a file
        if ($file = $this->path($parameters)) {
            $response = \with(new AssetCollection(array(
                new FileAsset($file)
            )))->dump();
        } elseif ($aParameters = json_decode($parameters, TRUE)) {

            array_walk($aParameters, function (&$item) {
                $item = new FileAsset($this->path($item));
            });

            $response = \with(new AssetCollection($aParameters))->dump();
        }

        if (isset($response)) {

            $headers = array();

            if (preg_match('/.css/i', $parameters)) {
                $headers['Content-Type'] = 'text/css';
            } elseif (preg_match('/.js/i', $parameters)) {
                $headers['Content-Type'] = 'text/javascript';
            } elseif (preg_match('/.html|.htm|.php/i', $parameters)) {
                $headers['Content-Type'] = 'text/html';
            } else {
                $file = new File($file);
                $mime = $file->getMimeType();
                if ($mime) {
                    $headers['Content-Type'] = $mime;
                } else {
                    $headers['Content-Type'] = 'text/html';
                }
            }

            return Response::make($response, 200, $headers);
        }

        return Response::make('', 404);
    }


    /**
     * Check file from registered path
     *
     * @param null $file
     * @return string
     */
    public function path($file = null)
    {
        $base_path = Composer::getRootPath();

        $pieces = explode('/', $file);

        # Add public to the path

        array_splice($pieces, 2, 0, 'public');

        $vendor_path = implode('/', $pieces);

        if(is_file($base_path.'/workbench/'. $vendor_path)){
            return $base_path.'/workbench/'. $vendor_path;
        } elseif(is_file($base_path.'/vendor/'. $vendor_path)){
            return $base_path.'/vendor/'. $vendor_path;
        } else {
            foreach($this->_paths as $path){
                $currentPath = $base_path.'/'.$path.'/'. $file;
                if (is_file($currentPath)) {
                    return $currentPath;
                }
            }
        }

        return false;
    }

}

namespace Arx;

class AssetsController extends controllers\AssetsController{

}