<?php

class h_response{

    /**
     * @var  integer     The response http status
     */
    public $result = false;
    public $code = 200;
    public $msg = null;
    public $data = null;

	// HTTP status codes and messages
    public static $messages = array(
        // Informational 1xx
        100 => 'Continue',
        101 => 'Switching Protocols',

        // Success 2xx
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',

        // Redirection 3xx
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found', // 1.1
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        // 306 is deprecated but reserved
        307 => 'Temporary Redirect',

        // Client Error 4xx
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',

        // Server Error 5xx
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        509 => 'Bandwidth Limit Exceeded'
    );

	public function __construct(){

		$iArgs = func_num_args();
		$aArgs = func_get_args();

		switch (true) {
			case $iArgs == 3:
				$this->result = $aArgs[0];
				$this->code = $aArgs[1];
				$this->msg = $aArgs[2];
				break;

			case $iArgs == 2 && is_array($aArgs[1]):
                $code = 200;
                $this->result = $aArgs[0];
                $this->code = $code;
                $this->msg = self::$messages[$code];
                $this->data = $aArgs[1];
			break;

			case $iArgs == 2 && is_integer($aArgs[1]):
				$this->result = $aArgs[0];
				$this->code = $aArgs[1];
				$this->msg = self::$messages[$aArgs[1]];
			break;

			case $iArgs == 2 && is_string($aArgs[1]):
                $this->result = $aArgs[0];
                $this->msg = $aArgs[1];
			break;

			case $iArgs == 1:
				$code = $aArgs[0] ? 200 : 400;
                $this->result = $aArgs[0];
                $this->code = $code;
                $this->msg = self::$messages[$code];
			break;
			
			default:
                $code = 400;
                $this->result = false;
                $this->code = $code;
                $this->msg = self::$messages[$code];
				break;
		}

	}

}