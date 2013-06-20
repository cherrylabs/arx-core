<?php
/**
    * Info extractor class
    * @file
    *
    * @package
    * @author Daniel Sum
    * @link 	@endlink
    * @see
    * @description
    *
    * @code 	@endcode
    * @comments
    * @todo
*/

class c_info
{
    public $function, $line, $file, $class, $object, $type, $args;

    public function __construct()
    {
        $aDebug = debug_backtrace();

        list($this->function, $this->line, $this->file, $this->class, $this->object, $this->type, $this->args) = array_values($aDebug[0]);

        return $this;
    }

    public function output()
    {
        predie($this);
    }

}
