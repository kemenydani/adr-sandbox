<?php

namespace App\Core;

abstract class Repository implements RepositoryInterface
{
    protected $db;

    static $table;
    static $model;

    public function find( $payload )
    {

    }

    public function all()
    {
        return DB::instance()->getRows('SELECT * FROM ' . self::getTable() );
    }

    public static function getTable()
    {
        return static::$table;
    }

    public function newRecordSet(array $rows)
    {
        $records = [];
        foreach ($rows as $row)
        {
            $records[] = $this->newRecord($row);
        }
        return new static::$modelSet($records);
    }

    public function newRecord(array $row)
    {
        return new static::$model($row);
    }
}
