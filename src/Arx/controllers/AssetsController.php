<?php namespace Arx;

use Response;
use App;

/**
 * Class Assets
 *
 * Assets controller template that you can extends in your Laravel App
 *
 * @status in dev
 * @package Arx\controllers
 */
class AssetsController extends \Controller {

    /**
     * Path should be always relative to the class
     *
     * @var string
     */
    public $path = '/../../public/assets';

    /**
     * @param array $parameters
     *
     * @return mixed|void
     */
    public function missingMethod($parameters = array())
    {
        $parameters = implode('/', $parameters);

        # If parameters is a file
        if ($file = $this->path($parameters)) {
            $response = \with(new AssetCollection(array(
                new FileAsset($file)
            )))->dump();
        }

        # If parament is in json format
        if ($aParameters = json_decode($parameters, TRUE)) {

            array_walk($aParameters, function (&$item) {
                $item = new FileAsset($this->path($item));
            });

            $response = \with(new AssetCollection($aParameters))->dump();
        }

        if (isset($response)) {

            if (preg_match('/.css/i', $parameters)) {
                header('Content-Type: text/css');
            } elseif (preg_match('/.js/i', $parameters)) {
                header('Content-Type: text/javascript');
            }
        }

        App::missing(function ($exception) {
            return Response::view('arx::404', array('message' => 'Not found'), 404);
        });

        return App::abort(404, 'Not found');
    }


    public function path($file = null)
    {

        $reflector = new \ReflectionClass(get_class($this));

        $response = realpath(dirname($reflector->getFileName()) . '/' . $this->path);

        if (!$response) {
            App::abort(404, 'Path not found');
        } elseif ($file) {
            $response .= '/' . $file;
            if (!is_file($response)) {
                return false;
            }
        }

        return $response;
    }

}

namespace Arx\controllers;

use Arx\AssetsController;

/**
 * Class Assets
 *
 * @deprecated please use Arx\AssetsController !
 * @package Arx\controllers
 */
class Assets extends AssetsController{}