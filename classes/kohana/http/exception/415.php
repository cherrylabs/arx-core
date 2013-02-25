<?php defined('SYSPATH') or die('No direct script access.');

class kohana_http_exception_415 extends HTTP_Exception
{
    /**
     * @var   integer    HTTP 415 Unsupported Media Type
     */
    protected $_code = 415;

}
