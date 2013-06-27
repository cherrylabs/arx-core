<?php
/**
     * Little Benchmark class
     * @author Daniel Sum
     * @version
     * @package
     * @description :
     * @comments :
*/

class c_bench
{
    private $aRecords;

    public function __construct()
    {
        $this->aRecords[] = array('time' => microtime(), 'starting'=> $key);
    }

    public function record($key = null)
    {
        $this->aRecords[] = array('time' => microtime(), 'name'=> $key);
    }

    public function output()
    {
        $aOutput = array();

        if(!is_array($this->aRecords))
            $this->aRecords = array($this->aRecords);

        foreach ($this->aRecords as $key => $r) {
            $aOutput[$key] = $r['time'];
            if ($key > 0) {
                //$aOutput[$key]['interval'] = self::diffMicrotime($r['time'], $this->aRecords[$key-1]['time']);
            }
        }

        return $aOutput;
    }

    public static function diffMicrotime($mt_old, $mt_new)
    {
        list($old_usec, $old_sec) = explode(' ', $mt_old);
        list($new_usec, $new_sec) = explode(' ', $mt_new);
        $old_mt = ((float) $old_usec + (float) $old_sec);
        $new_mt = ((float) $new_usec + (float) $new_sec);

        return $new_mt - $old_mt;
    }

}
