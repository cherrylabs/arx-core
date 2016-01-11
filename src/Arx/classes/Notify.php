<?php namespace Arx\classes;

use Arx\SingletonTrait;
use Illuminate\Http\Request;

class Notify
{
    /**
     * The session writer.
     *
     * @var Session
     */
    private $session;
    private $hook;

    use SingletonTrait;

    /**
     * Default settings
     *
     * @var array
     */
    public $settings = [];

    /**
     * Create a new flash notifier instance.
     *
     * @param Request $request
     * @internal param SessionStore|\Session $session
     * @internal param Hook $hook
     */
    function __construct(Request $request)
    {
        $this->session = app('request')->session();
        $this->hook = new Hook();
    }

    /**
     * Flash an information message.
     *
     * @param string $message
     * @return $this
     */
    public function info($message)
    {
        $this->message($message, 'info');
        return $this;
    }
    /**
     * Flash a success message.
     *
     * @param  string $message
     * @return $this
     */
    public function success($message)
    {
        $this->message($message, 'success');
        return $this;
    }
    /**
     * Flash an error message.
     *
     * @param  string $message
     * @return $this
     */
    public function error($message)
    {
        return $this->danger($message);
    }

    public function danger($message){
        $this->message($message, 'danger');
        return $this;
    }

    /**
     * Flash a warning message.
     *
     * @param  string $message
     * @return $this
     */
    public function warning($message)
    {
        $this->message($message, 'warning');
        return $this;
    }

    /**
     * Flash a general message.
     *
     * @param  string $message
     * @param  string $level
     * @return $this
     */
    public function message($message, $level = 'info')
    {
        $this->set(['message' => $message], ['type' => $level]);
        return $this;
    }

    /**
     * Set the flash element
     *
     * @param $options
     * @param $settings
     * @return $this
     */
    public function set($options = [
        'icon' => null,
        'title' => null,
        'message' => '',
        'url' => null,
        'target' => null
    ], $settings = []){
        $settings = Arr::merge($this->settings, $settings);
        $this->session->flash('notify.options', $options);
        $this->session->flash('notify.settings', $settings);
        $this->hook->put('__app.notify.options', $options);
        $this->hook->put('__app.notify.settings', $settings);
        return $this;
    }
}