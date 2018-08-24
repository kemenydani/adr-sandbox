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
        $stmt = <<<STMT
            SELECT * FROM `user`
STMT;

        return $this->newRecordSet( $this->db->getRows($stmt) );
    }

    public function find($id)
    {
        $stmt = <<<STMT
            SELECT * FROM `user`
            WHERE Id = ? LIMIT 1 
STMT;

        $row = $this->db->getRow($stmt, $id);

        return $row ? $this->newRecord($row) : null;
    }

    public function getNotifications(UserRecord $UserRecord, $limit = 100) : array
    {
        $stmtLimit = $limit ? " LIMIT " . (int)$limit : "";

        $stmt = <<<STMT
            SELECT * FROM user_notification
            WHERE UserId = :UserId 
            ORDER BY Id DESC $stmtLimit
STMT;

        return $this->db->getRows($stmt, [
            'UserId' => $UserRecord->getId(),
        ]);
    }

    public function getConversations(UserRecord $UserRecord, $limit = null) : array
    {
        $stmtLimit = $limit ? " LIMIT " . (int)$limit : "";

        $stmt = <<<STMT
            SELECT uc.*, u.UserName AS LastMessageUser, ucm.Text AS LastMessageText FROM user_conversation uc
              LEFT JOIN user_conversation_message ucm
                ON ucm.Id = ( SELECT max(Id) FROM user_conversation_message ucm2 WHERE ucm2.ConversationId = uc.Id )
              LEFT JOIN `user` u
                ON u.Id = ucm.SenderId
            WHERE uc.CreatorUserId = :UserId OR uc.TargetUserId = :UserId $stmtLimit
STMT;

        $rows = $this->db->getRows($stmt, [
            'UserId' => $UserRecord->getId(),
        ]);

        return $rows;
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

