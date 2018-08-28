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
        $stmt = <<<STMT
            SELECT * FROM `article`
STMT;

        return $this->newRecordSet( $this->db->getRows($stmt) );
    }

    public function insertRecord(ArticleRecord $record)
    {

    }

    public function updateRecord(ArticleRecord $record)
    {

    }

    // create entity based queries...

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

