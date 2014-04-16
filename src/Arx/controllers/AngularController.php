<?php namespace Arx\controllers;

use App, Request, Response;
use Arx\classes\Utils;

/**
 * Class Angular
 *
 * Angular controller template that you can extends in your Laravel App
 *
 * @status don't use it in prod
 * @todo more features
 * @package Arx\controllers
 */
class Angular extends \Controller
{
    /**
     * @param array $parameters
     *
     * @return mixed|void
     */
    public function missingMethod($parameters = array())
    {
        $path = \app_path( Request::segment(1). '/' . implode('/', $parameters));

        if (is_file($path)) {
            $response = Response::make(file_get_contents($path));
            $response->header('Content-Type', 'application/javascript');
            return $response;
        }

        return App::abort(404, 'Not found');
    }

}

namespace Arx;

use Arx\controllers\Angular;

class AngularController extends Angular
{

}