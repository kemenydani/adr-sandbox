<?php

namespace App\Core;

abstract class Repository implements RepositoryInterface
{
    protected $db;

    public function __construct()
    {
        $this->db = DB::instance();
    }

    public function find( $payload )
    {

    }

    public function all()
    {

    }

    public static function getTable()
    {

    }
}
