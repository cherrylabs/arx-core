<?php defined('SYSPATH') or die('No direct script access.');

class kohana_http_exception_403 extends HTTP_Exception
{
    /**
     * @var   integer    HTTP 403 Forbidden
     */
    protected $_code = 403;

}
