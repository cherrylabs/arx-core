<?php namespace Arx;

class c_app extends \Slim\Slim
{
    /**
     * Get default application settings
     * @return array
     */
    public static function getDefaultSettings()
    {
        return array(
            // Application
            'mode' => 'development',
            // Debugging
            'debug' => true,
            // Logging
            'log.writer' => null,
            'log.level' => \Slim\Log::DEBUG,
            'log.enabled' => true,
            // View
            'templates.path' => ARX_DIR.DS.VIEWS.DS,
            'view' => '\Arx\c_view',
            // Cookies
            'cookies.lifetime' => '20 minutes',
            'cookies.path' => '/',
            'cookies.domain' => null,
            'cookies.secure' => false,
            'cookies.httponly' => false,
            // Encryption
            'cookies.secret_key' => "CHANGE_ME",
            'cookies.cipher' => MCRYPT_RIJNDAEL_256,
            'cookies.cipher_mode' => MCRYPT_MODE_CBC,
            // HTTP
            'http.version' => '1.1'
        );
    }

    public static function any(){
        $args = func_get_args();

        $t = self::getInstance();

        return $t->mapRoute($args)->via(\Slim\Http\Request::METHOD_GET, \Slim\Http\Request::METHOD_HEAD, \Slim\Http\Request::METHOD_OPTIONS);
    }

    public function notFound( $callable = null ) {

    }

}