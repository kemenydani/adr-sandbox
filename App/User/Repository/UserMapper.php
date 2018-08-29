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

    public function find($keyword, $key = 'Id')
    {
        $stmt = <<<STMT
            SELECT * FROM `user`
            WHERE $key = :$key LIMIT 1 
STMT;

        $row = $this->db->getRow($stmt, [ $key => $keyword ]);

        return $row ? $this->newRecord($row) : null;
    }

    public function search($where = null)
    {
        $stmt = <<<STMT
            SELECT * FROM `user` u 
STMT;
        $binds = [];

        $rows = $this->db->getRows($stmt, $binds);

        return $this->newRecordSet($rows);
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

    public function install()
    {
        /**
         * user
         */
        $stmt_user = <<<STMT_USER
            create table `user`
            (
                Id int(11) unsigned auto_increment
                    constraint `PRIMARY`
                        primary key,
                UserName varchar(40) null,
                Email varchar(255) null,
                Password text not null
            )
            engine=InnoDB
            ;
STMT_USER;

        $this->db->query($stmt_user);

        /**
         * user_notification
         */
        $stmt_user_notification = <<<STMT_USER_NOTIFICATION
            create table user_notification
            (
                Id int unsigned auto_increment
                    constraint `PRIMARY`
                        primary key,
                UserId int unsigned not null,
                Touched tinyint(1) default '0' null,
                CreatedAt timestamp default CURRENT_TIMESTAMP null,
                Message varchar(255) null
            )
            engine=InnoDB
            ;
STMT_USER_NOTIFICATION;

        $this->db->query($stmt_user_notification);

        /**
         * user_conversation
         */
        $stmt_user_conversation = <<<STMT_USER_CONVERSATION
            create table user_conversation
            (
                Id int(11) unsigned auto_increment
                    constraint `PRIMARY`
                        primary key,
                CreatorUserId int(11) unsigned not null,
                TargetUserId int(11) unsigned not null,
                DateStarted datetime default CURRENT_TIMESTAMP not null,
                SeenByCreator tinyint(1) not null,
                SeenByTarget tinyint(1) not null
            )
            engine=InnoDB
            ;
STMT_USER_CONVERSATION;

        $this->db->query($stmt_user_conversation);

        /**
         * user_conversation_message
         */
        $stmt_user_conversation_message = <<<STMT_USER_CONVERSATION_MESSAGE
            create table user_conversation_message
            (
                Id int(11) unsigned auto_increment
                    constraint `PRIMARY`
                        primary key,
                ConversationId int(11) unsigned not null,
                DatePosted datetime default CURRENT_TIMESTAMP not null,
                Text text null,
                SenderId int(11) unsigned not null
            )
            engine=InnoDB
            ;
STMT_USER_CONVERSATION_MESSAGE;

        $this->db->query($stmt_user_conversation_message);

    }

}

