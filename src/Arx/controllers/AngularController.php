<?php namespace Arx\controllers;

use App, Request, Response;

/**
 * Class Angular
 *
 * Angular controller template that you can extends in your Laravel App to protect some Angular script with a middleware
 * and filters
 *
 * @package Arx\controllers
 */
class AngularController extends \Controller
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

        App::abort(404, 'Not found');
    }

}