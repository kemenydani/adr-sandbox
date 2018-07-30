<?php

namespace App\Core;

class RecordSet extends \ArrayObject
{
    public function with($class)
    {

    }

    public function getData()
    {
        $iterator = $this->getIterator();

        $data = [];

        while($iterator->valid())
        {
            $data[] = ($iterator->current())->getData();
            $iterator->next();
        }

        return $data;
    }
}