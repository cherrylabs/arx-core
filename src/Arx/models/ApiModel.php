<?php namespace Arx;

/**
 * Class ApiModel Skeleton
 *
 * @package Arx
 */
class ApiModel extends classes\Singleton implements ApiInterface {

    private static $API_KEY = "";
    private static $API_SECRET = "";
    private static $API_BASE_URL = "";

    private static $_aInstances = array();

    public function __construct($param = array('key' => null, 'secret' => null))
    {

        if (!$param['key'] && !$param['secret']) {
            Throw new \Exception('Api Key and Secret must be defined');
        }

        self::$API_SECRET = $param['secret'];
        self::$API_KEY = $param['key'];
    }

    /**
     * Calling method from Api
     *
     * @param $uri
     * @param array $param
     * @param null $method
     * @return array|mixed
     * @throws \Exception
     */
    public function call($uri, $param = array(), $method = null)
    {
        $url = self::$API_BASE_URL . $uri;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        date_default_timezone_set('UTC');
        $date = date('Y-m-d H:i:s');

        $signature = sha1(self::$API_SECRET . $date);

        $headers = array(
            'APIKEY: ' . self::$API_KEY,
            'DATE: ' . $date,
            'SIGNATURE: ' . $signature,
            'Content-Type: application/json',
            'Accept: application/json'
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if ($method == 'PUT') {
            curl_setopt($ch, CURLOPT_PUT, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($param));
        } elseif ($method == 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($param));
        } elseif (!$method && count($param) || $method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($param));
        }

        $result = curl_exec($ch);

        if (!$result || curl_errno($ch)) {
            Throw new \Exception(curl_error($ch));
        } else {

            $json = json_decode($result, true);

            if ($json) {
                $result = $json;
            }
        }

        return $result;
    }

    /**
     * Allow to configure Api Key and Secret
     *
     * @param array $param
     * @throws \Exception
     */
    public static function configure($param = array('key' => null, 'secret' => null))
    {

        if (!$param['key'] && !$param['secret']) {
            Throw new \Exception('Api Key and Secret must be defined');
        }

        self::$API_SECRET = $param['secret'];
        self::$API_KEY = $param['key'];
    }

    /**
     * Get a Textmaster instance already instanciated
     *
     * @example : Textmaster::getInstance()
     * @return mixed
     */
    public static function getInstance()
    {
        $sClass = get_called_class();

        if (!isset(self::$_aInstances[$sClass])) {
            self::$_aInstances[$sClass] = new $sClass();
        }

        return self::$_aInstances[$sClass];
    }

}