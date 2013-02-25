<?php defined('SYSPATH') or die('No direct script access.');

class kohana_http_exception_500 extends HTTP_Exception
{
    /**
     * @var   integer    HTTP 500 Internal Server Error
     */
    protected $_code = 500;

}
