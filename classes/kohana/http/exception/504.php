<?php defined('SYSPATH') or die('No direct script access.');

class kohana_http_exception_504 extends HTTP_Exception
{
    /**
     * @var   integer    HTTP 504 Gateway Timeout
     */
    protected $_code = 504;

}
