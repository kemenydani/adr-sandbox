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
     * @return array
     */
    public function getData() : array
    {
        $properties = get_object_vars($this);
        return $properties;
    }
}
