<?php namespace Arx;

class c_route extends \Slim\Slim
{
    /**
     * Error Handler
     *
     * This method defines or invokes the application-wide Error handler.
     * There are two contexts in which this method may be invoked:
     *
     * 1. When declaring the handler:
     *
     * If the $argument parameter is callable, this
     * method will register the callable to be invoked when an uncaught
     * Exception is detected, or when otherwise explicitly invoked.
     * The handler WILL NOT be invoked in this context.
     *
     * 2. When invoking the handler:
     *
     * If the $argument parameter is not callable, Slim assumes you want
     * to invoke an already-registered handler. If the handler has been
     * registered and is callable, it is invoked and passed the caught Exception
     * as its one and only argument. The error handler's output is captured
     * into an output buffer and sent as the body of a 500 HTTP Response.
     *
     * @param  mixed $argument Callable|Exception
     * @return void
     */
    public function error($argument = null)
    {
        if (is_callable($argument)) {
            //Register error handler
            $this->router->error($argument);
        } else {
            //Invoke error handler
            $this->response->status(500);
            $this->response->body('');
            $this->response->write($this->callErrorHandler($argument));
            $this->stop();
        }
    }

    protected static function generateTemplateMarkup($title, $body)
    {
        return sprintf("<html><head><title>%s</title><style>body{margin:0;padding:30px;font:12px/1.5 Helvetica,Arial,Verdana,sans-serif;}h1{margin:0;font-size:48px;font-weight:normal;line-height:48px;}strong{display:inline-block;width:65px;}</style></head><body><h1>%s</h1>%s</body></html>", $title, $title, $body);
    }

    /**
     * Default Not Found handler
     * @return void
     */
    protected function defaultNotFound()
    {
        //echo self::generateTemplateMarkup('404 Page Not Found', '<p>The page you are looking for could not be found. Check the address bar to ensure your URL is spelled correctly. If all else fails, you can visit our home page at the link below.</p><a href="' . $this->request->getRootUri() . '/">Visit the Home Page</a>');
    }

     /**
      * Handle errors
      *
      * This is the global Error handler that will catch reportable Errors
      * and convert them into ErrorExceptions that are caught and handled
      * by each Slim application.
      *
      * @param  int $errno   The numeric type of the Error
      * @param  string $errstr  The error message
      * @param  string $errfile The absolute path to the affected file
      * @param  int $errline The line number of the error in the affected file
      * @return true
      * @throws ErrorException
      */
    public static function handleErrors($errno, $errstr = '', $errfile = '', $errline = '')
    {
        if (error_reporting() & $errno) {
            throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
        }

        return true;
    }

}