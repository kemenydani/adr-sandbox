<?php

namespace App\Core;

abstract class Record
{
    /**
     * Record constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->setData($data);
    }

    public function with($class)
    {

    }

    public function __get(string $key)
    {
        return $this->$key;
    }

    public function __set(string $key, $val)
    {
        $this->$key = $val;
    }

    /**
     * @param array $data
     */
    public function setData(array $data = [])
    {
        foreach ($data as $key => $value)
        {
            if (property_exists($this, $key))
            {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * @param array $filter
     * @param bool $exclude
     * @return array
     */
    public function getData($filter = [], $exclude = false) : array
    {
        return count($filter) ? ( $exclude ? array_keys_excluded(get_object_vars($this), $filter) : array_keys_included(get_object_vars($this), $filter) ) : get_object_vars($this);
    }
}
