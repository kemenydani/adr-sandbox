<?php

namespace App\Article\Repository;

use App\Core\DB;
use App\Core\RecordMapper;

class ArticleMapper extends RecordMapper
{
    /**
     * @var DB
     */
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

    public function paginate($search = [], $currentPage = 1, $perPage = 0, $sortBy = 'Id', $sortDirection = 'DESC')
    {
        $stmtOrder = " ORDER BY " . $sortBy . " " . $sortDirection . " ";
        $stmtLimit = " LIMIT " . ( $currentPage - 1 ) * $perPage . ", " . $perPage ." ";

        $stmt = <<<STMT
            SELECT SQL_CALC_FOUND_ROWS * FROM `article`$stmtOrder $stmtLimit
STMT;

        $items = $this->db->getRows($stmt);
        $totalItems = $this->db->totalRowCount();
        $totalPages = (int)ceil($totalItems / $perPage);

        $RecordSet = $this->newRecordSet( $items );
        $RecordSet->setTotalItems($totalItems);
        $RecordSet->setCurrentPage($currentPage);
        $RecordSet->setTotalpages($totalPages);

        return $RecordSet;
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

