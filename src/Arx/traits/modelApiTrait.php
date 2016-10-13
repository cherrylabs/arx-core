<?php namespace Arx\traits;

use Arr;
use Arx\classes\Convert;
use Illuminate\Http\JsonResponse;
use Input;
use Log;
use Request;
use Response;

/**
 * Class modelApiTrait
 *
 * Usefull model api trait usable for your business logic
 *
 * @package Arx\traits
 */
trait modelApiTrait {

    /**
     * Api Current Version
     *
     * @var string
     */
    public static $version = "1.0.0";

#H
    /**
     * Handle Error => if Stagging BETA or PROD => Log error only
     * => if not throw error
     *
     * @param $e
     * @throws
     */
    public static function handleError($e)
    {
        if (!defined('LEVEL_ENV')) {
            define('LEVEL_ENV', 3);
        }

        if (is_array($e)) {
            $e = new Exception('Error with : ' . json_encode($e));
        }

        if (LEVEL_ENV < 2) {
            Throw $e;
        }

        Log::error($e);
    }

#I
    /**
     * Check if request is Ajax
     *
     * @return bool
     */
    public static function isAjax()
    {
        return Request::isJson() || Input::has('ajax');
    } //

    #R

    /**
     * Response Wrapper Helper
     *
     * It return 400 code status if no data
     *
     * @param array $mdata
     * @param bool $status
     * @param string $msg
     *
     * @return array
     */
    public static function response($mdata = array(), $status = null, $msg = '')
    {
        if (is_array($mdata) && isset($mdata['msg']) && isset($mdata['data']) && isset($mdata['status']) && !$status) {
            $status = $mdata['status'];
            $msg = $mdata['msg'];
            $mdata = $mdata['data'];
        }


        if (!$status && count($mdata)) {
            $status = 200;
        } elseif (!$status) {
            $status = 400;
        }


        $response = array(
            'status' => $status,
            'msg' => $msg,
            'data' => $mdata
        );

        return $response;
    } // response


    /**
     * Response Required
     *
     * It return 400 code status if no data
     *
     * @param array $mdata
     * @param bool $status
     * @param string $msg
     *
     * @return array
     */
    public static function responseErrors($mdata = array(), $status = null, $msg = '')
    {
        if (is_array($mdata) && isset($mdata['msg']) && isset($mdata['data']) && isset($mdata['status']) && !$status) {
            $status = $mdata['status'];
            $msg = $mdata['msg'];
            $mdata = $mdata['data'];
        }


        if (!$status && count($mdata)) {
            $status = 200;
        } elseif (!$status) {
            $status = 400;
        }

        $response = array(
            'status' => $status,
            'msg' => $msg,
            'data' => $mdata,
            'errors' => $mdata
        );

        return $response;
    } // response

    /**
     * Return a formatted ResponseJson
     *
     * @param array $mdata
     * @param null $status
     * @param string $msg
     * @param array $headers
     * @param int $options
     * @return JsonResponse
     */
    public static function responseJson($mdata = array(), $status = null, $msg = '', array $headers = array(), $options = 0)
    {
        $response = self::response($mdata, $status, $msg);
        return Response::json($response, $response['status'], $headers, $options);
    } // response

    /**
     * Return a formatted ResponseJson
     *
     * @param array $mdata
     * @param array $mergedData
     * @param null $status
     * @param string $msg
     * @param array $headers
     * @param int $options
     * @return JsonResponse
     */
    public static function responseJsonMerge($mdata = array(), $mergedData, $status = null, $msg = '', array $headers = array(), $options = 0)
    {
        $response = self::responseMerge($mdata, $mergedData, $status, $msg);
        return Response::json($response, $response['status'], $headers, $options);
    } // response

    /**
     * Return a formatted ResponseJson
     *
     * @param array $mdata
     * @param null $status
     * @param string $msg
     * @param array $headers
     * @param int $options
     * @return JsonResponse
     */
    public static function responseJsonError($mdata = array(), $status = null, $msg = '', array $headers = array(), $options = 0)
    {
        $response = self::responseError($mdata, $status, $msg);

        return Response::json($response, $response['status'], $headers, $options);
    } // response

    /**
     * Return a formatted ResponseJson
     *
     * @param array $mdata
     * @param null $status
     * @param string $msg
     * @param array $headers
     * @param int $options
     * @return JsonResponse
     */
    public static function responseError($mdata = array(), $status = null, $msg = null)
    {
        if (!$status) {
            $status = 400;
        }

        if (method_exists($mdata, 'getFile')) {
            $data = [
                "msg" => $msg ?: $mdata->getMessage(),
                "status" => $status,
                "data" => [],
            ];
            if (LEVEL_ENV < 2) {
                $data['data']['file'] = $mdata->getFile();
                $data['data']['line'] = $mdata->getLine();
                $data['data']['code'] = $mdata->getCode();
                $data['data']['debug'] = debug_backtrace();
            }
        } else{
            $data = [
                "msg" => $msg,
                "status" => $status,
                "data" => $mdata,
            ];
        }

        return $data;
    } // response


    /**
     * Little response helper to merge data
     *
     * @example Api::responseMerge()
     * @param $mdata
     * @param $mergedData
     * @param null $status
     * @param null $msg
     * @return array
     * @internal param $data
     */
    public static function responseMerge($mdata, $mergedData, $status = null, $msg = null){
        $data = self::response($mdata, $status, $msg);

        $data = Arr::merge($data, $mergedData);

        return $data;
    }

    /**
     * Get Relative path to the public folder
     *
     * @param $path
     * @return mixed
     */
    public static function relativePath($path)
    {
        return str_replace(public_path(), '', $path);
    }


    /**
     * Get Countries available
     */
    public static function getCountries()
    {
        // Put frequently country at the top
        $countries = array();
        $frequently = array();

        foreach (Convert::$aCountries as $k => $country) {
            //echo strtolower($k) . '<br />';
            if (in_array(strtolower($k), ['be', 'fr', 'gb'])) {
                $frequently[strtolower($k)] = $country;
            } else {
                $countries[strtolower($k)] = $country;
            }
        }

        return array_merge($frequently, $countries);
    }
}