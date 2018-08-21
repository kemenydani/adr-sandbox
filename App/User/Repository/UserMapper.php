<?php

namespace App\User\Repository;

use App\Core\DB;
use App\Core\RecordMapper;

class UserMapper extends RecordMapper
{
    private $db;
    private $table = 'user';
    private $primary = 'Id';

    const RECORDS = [
        'Id' => [
            'type'  => 'int',
            'rules' => 'int,unique',
        ],
        'UserName' => [
            'type' => 'string',
            'rules' => 'min:0,max:40,filter:alphanumeric',
            'default'  => null,
        ],
        'Email' => [
            'type' => 'string',
            'rules' => 'min:0,max:255,unique,filter:email',
            'default'  => null,
        ],
        'Password' => [
            'type' => 'string',
            'rules' => 'min:6,match:password'
        ]
    ];

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

    public function find($id)
    {
        $row = $this->db->getRow('SELECT * FROM ' . $this->table . ' WHERE Id = ? LIMIT 1 ', $id);

        return $row ? $this->newRecord($row) : null;
    }

    public function getNotifications(UserRecord $UserRecord) : array
    {
        $stmt = "SELECT * FROM user_notification WHERE UserId = ? AND Touched = ?";

        return $this->db->getRows($stmt, [
            'UserId' => $UserRecord->getId(),
            'Touched' => false
        ]);
    }

    /*
    public function getProfile(UserRecord $UserRecord)
    {
        $stmt = "SELECT * FROM user_profile WHERE UserId = ?";

        return $this->db->getRow($stmt, $UserRecord->getId());
    }
    */

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

