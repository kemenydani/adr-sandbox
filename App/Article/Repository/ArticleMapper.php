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

    public function paginate($search = '', $page = 1, $rowsPerPage = 5, $sortBy = '', $descending = true)
    {
        $descending = toBool($descending);

        $direction = $descending === true ? "DESC" : "ASC";

        $orderBy = "ORDER BY $sortBy $direction";
        $start = ( $page - 1 ) * $rowsPerPage;
        $limit = "LIMIT $start, $rowsPerPage";

        $stmt = <<<STMT
            SELECT SQL_CALC_FOUND_ROWS * FROM `article` $orderBy $limit
STMT;

        $items = $this->db->getRows($stmt);
        $totalItems = $this->db->totalRowCount();
        $totalPages = (int)ceil($totalItems / $rowsPerPage);

        return [
            'items' => $items,
            'page' => (int)$page,
            'totalPages' => (int)$totalPages,
            'totalItems' => (int)$totalItems,
            'sortBy' => $sortBy,
            'rowsPerPage' => (int)$rowsPerPage,
            'descending' => $descending,
        ];
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

