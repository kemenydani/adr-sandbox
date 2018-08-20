<?php

namespace App\User\Repository;

use App\Core\Record;

class UserRecord extends Record
{
    protected $Id;
    protected $UserName;
    protected $Email;
    protected $Password;
}