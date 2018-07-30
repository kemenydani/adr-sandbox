<?php

namespace App\Article\Repository;

use App\Core\DB;
use App\Core\RecordMapper;

class ArticleMapper extends RecordMapper
{
    private $db;
    private $table = 'Article';
    private $id = 'id';

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

    public function newRecord(array $row) : ArticleRecord
    {
        return new ArticleRecord($row);
    }

    public function newRecordSet(array $rows) : ArticleRecordSet
    {
        $records = [];
        foreach ($rows as $row) $records[] = $this->newRecord($row);
        return new ArticleRecordSet($records);
    }

}

