<?php namespace Arx\classes;

use Illuminate\View\View as ParentClass;
use Illuminate\View\Environment;
use Illuminate\View\Engines\EngineInterface;

class View extends ParentClass {

    /**
     * The view environment instance.
     *
     * @var \Illuminate\View\Environment
     */
    protected $environment;

    /**
     * The engine implementation.
     *
     * @var \Illuminate\View\Engines\EngineInterface
     */
    protected $engine;

    /**
     * The name of the view.
     *
     * @var string
     */
    protected $view;

    /**
     * The array of view data.
     *
     * @var array
     */
    protected $data;

    /**
     * The path to the view file.
     *
     * @var string
     */
    protected $path;


    /**
     * Create a new view instance.
     *
     * @param  \Illuminate\View\Environment  $environment
     * @param  \Illuminate\View\Engines\EngineInterface  $engine
     * @param  string  $view
     * @param  string  $path
     * @param  array   $data
     * @return void
     */
    public function __construct(Environment $environment, EngineInterface $engine, $view, $path, $data = array())
    {
        $this->view = $view;
        $this->path = $path;
        $this->engine = $engine;
        $this->environment = $environment;

        $this->data = $data instanceof Arrayable ? $data->toArray() : (array) $data;
    }

    /**
     * @param $file
     * @param $data
     */
    public static function make($file, $data){

        $config = new Config();

        $path = Config::get('app.views.path');

        $app = App::getInstance();

        if(!is_file($file)){
            $file = Config::get('app.view.path').$file.Config::get('app.view.extension');

            if(!is_file($path.$file.'.php')){
                $file = __DIR__.'/../views/'.$file.'.php';
            }
        }

        if(is_file($file)){

            ob_start();
            extract($data);
            echo include( $file );
            $content = ob_get_contents();
            ob_flush();

        } else {
            Debug::error('Cannot open %s%', $file);
        }
    }
}