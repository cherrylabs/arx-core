<?php namespace Arx\controllers;

use Response;
use App;

use Assetic\Asset\AssetCollection;
use Assetic\Asset\FileAsset;
use Assetic\Asset\GlobAsset;

class Assets extends \Controller implements \Arx\interfaces\Assets
{

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
    public function missingMethod($parameters)
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
            die($response);
        }

        App::missing(function ($exception) {
            return Response::view('arx::404', array('message' => 'Not found'), 404);
        });

        return App::abort(404, 'Not found');
    }

    public function js($parameters)
    {
        return $this->missingMethod($parameters);
    }

    public function css($parameters)
    {
        return $this->missingMethod($parameters);

    }

    public function img($parameters)
    {
        return $this->missingMethod($parameters);

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

namespace Arx;

use Arx\controllers\Assets;

class AssetsController extends Assets
{

}