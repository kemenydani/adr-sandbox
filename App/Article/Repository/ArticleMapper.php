<?php

namespace App\Article\Repository;

use App\Core\DB;
use App\Core\RecordMapper;

class ArticleMapper extends RecordMapper
{
    private $db;
    private $table = 'article';
    private $id = 'Id';

    public function __construct()
    {
        $this->db = DB::instance();
    }

    public function all()
    {
        return $this->newRecordSet(
            $this->db->getRows('SELECT * FROM ' . $this->table)
        );
    }

    public function insertRecord(UserRecord $record)
    {

    }

    public function updateRecord(UserRecord $record)
    {

    }

    // create entity based queries...

    public function newRecord(array $row) : UserRecord
    {
        return new UserRecord($row);
    }

    public function newRecordSet(array $rows) : UserRecordSet
    {
        $records = [];
        foreach ($rows as $row) $records[] = $this->newRecord($row);
        return new UserRecordSet($records);
    }

}

