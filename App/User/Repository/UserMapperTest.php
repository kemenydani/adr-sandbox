<?php

namespace App\User\Repository;

use PHPUnit\Framework\TestCase;

class UserMapperTest extends TestCase
{
    public function test_search()
    {
        $UserMapper = new UserMapper();
        $this->assertInstanceOf(UserRecordSet::class, $UserMapper->search());
    }

    public function test_find()
    {
        $UserMapper = new UserMapper();
        $this->assertInstanceOf(UserRecord::class, $UserMapper->find(1));
    }

    public function test_getConversationsReturnsArray()
    {
        $UserMapper = new UserMapper();
        $UserRecord = $UserMapper->find(1);
        $this->assertInternalType('array', $UserMapper->getConversations($UserRecord, 5));
    }
}
