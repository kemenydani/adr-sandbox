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
    public $fetchMode = null;

    public function __construct($dsn, $username, $password, $options)
    {
        parent::__construct($dsn, $username, $password, $options);

        $this->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
        $this->exec("set names utf8");
    }

    public function getStmt()
    {
        return $this->stmt;
    }

    public static function instance( $fetchMode = null )
    {
        if ( self::$_instance === null )
        {
            $dsn = 'mysql:host='.self::$_HOST_.';dbname='.self::$_DATABASE_.'';
            self::$_instance = new DB($dsn, self::$_USERNAME_, self::$_PASSWORD_, []);
        }

        self::$_instance->setFetchMode(\PDO::FETCH_ASSOC);

        if($fetchMode) self::$_instance->setFetchMode($fetchMode);

        return self::$_instance;
    }

    public function getRows($stmt = "", $bind = null)
    {
        return $this->get($stmt, $bind = null);
    }

    public function getRow($stmt = "", $bind = null)
    {
        return $this->get($stmt, $bind = null, false);
    }

    private function get($stmt = "", $bind = null, $fetchAll = true)
    {
        if(!strlen($stmt)) return null;

        $binds = is_array($bind) ? $bind : ($bind !== null ? [$bind] : []);

        $q = $this->prepare($stmt);

        $bi = 1;
        foreach($binds as $bk => $bv)
        {
            $n = is_string($bk) ? ':' . $bk : $bi;
            $q->bindValue($n, $bv);
            $bi++;
        }

        $q->execute();
        $r = $fetchAll ? $q->fetchAll($this->getFetchMode()) : $q->fetch($this->getFetchMode());

        return $r ? $r : [];
    }

    public function insertRow($table, array $data)
    {
        $stmt  = " INSERT INTO {$table}";
        $stmt .= "(" .  self::questionMarkList(count($data)) . ")";
        $stmt .= "VALUES (" . rtrim(str_repeat('?,', count($data)),',') . ")";
    }

    public static function commaList($data)
    {

    }

    public static function questionMarkList($count)
    {
        return rtrim(str_repeat('?,', $count),',');
    }

    public function updateRow($table, array $where)
    {

    }

    public function deleteRow($table, array $where)
    {

    }

    public function wipeTable($table)
    {

    }

    public function getFetchMode()
    {
        return $this->fetchMode;
    }

    public function setFetchMode($mode)
    {
        $this->fetchMode = $mode;
    }

}
