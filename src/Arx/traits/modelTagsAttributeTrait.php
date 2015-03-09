<?php namespace Arx\traits;

trait modelTagsAttributeTrait {
    /**
     * Get Tags
     *
     * @param $value
     * @return array|mixed
     */
    public function getTagsAttribute($value)
    {

        if (is_array($value)) {
            return $value;
        }

        $return = json_decode($value, true);

        if (!is_array($return))
            return array();
        else
            return $return;
    }
}