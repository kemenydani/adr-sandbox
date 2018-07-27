<?php

namespace App\Core;

class DB extends \PDO
{
    public static $_instance;

    private static $_PREFIX_ = '';
    private static $_HOST_ = 'localhost';
    private static $_DATABASE_ = 'sandbox1';
    private static  $_USERNAME_ = 'root';
    private static  $_PASSWORD_ = '';

    public $stmt = null;

    public function __construct($dsn, $username, $password, $options)
    {
        parent::__construct($dsn, $username, $password, $options);

        $this->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
        $this->exec("set names utf8");
    }

    public function getStmt(){
        return $this->stmt;
    }

    public static function instance()
    {
        if ( self::$_instance === null )
        {
            $dsn = 'mysql:host='.self::$_HOST_.';dbname='.self::$_DATABASE_.'';
            self::$_instance = new DB($dsn, self::$_USERNAME_, self::$_PASSWORD_, []);
        }
        return self::$_instance;
    }

}
