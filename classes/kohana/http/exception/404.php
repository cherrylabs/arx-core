<?php defined('SYSPATH') or die('No direct script access.');

class kohana_http_exception_404 extends HTTP_Exception
{
    /**
     * @var   integer    HTTP 404 Not Found
     */
    protected $_code = 404;

}
