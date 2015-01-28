<?php namespace Arx;

use Arx\classes\Arr;

/**
 * Class QueuableTrait
 *
 * Allow each method of the Api to be queuable to improve performance
 *
 * @package Arx
 */
trait QueuableTrait{
    /**
     * Push a task to the queue list
     *
     * @throws \Exception if Api methods is not callable
     */
    public static function push()
    {

        $param = func_get_args();

        $method = $param[0];

        if (!method_exists(get_class(), $method)) {
            Throw new \Exception('Api method ' . $method . ' is not callable');
        }

        unset($param[0]);

        \Queue::push('Api@fire', array('@method' => $method) + $param);
    }

    /**
     * Fire a task in background using Beanstalkd
     *
     * @param $job Illuminate\Queue\Jobs\BeanstalkdJob
     * @param $data array
     *
     * @return void
     */
    public static function fire($job, $data)
    {

        \Log::info('Queue job called #' . $job->getJobId(), Arr::toArray($data));

        $method = $data['@method'];

        unset($data['@method']);

        $t = self::getInstance();

        call_user_func_array(array($t, $method), $data);

        $job->delete();
    }
}
