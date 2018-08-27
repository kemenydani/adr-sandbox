<?php

namespace App\Core;

class Session
{
    public static function exists($name)
    {
        return (isset($_SESSION[$name])) ? true : false;
    }
    public static function get($name)
    {
        return $_SESSION[$name];
    }
    public static function put($name, $value)
    {
        $_SESSION[$name] = $value;
        session_write_close();
        return $_SESSION[$name];
    }
    public static function delete($name)
    {
        if(self::exists($name))
        {
            unset($_SESSION[$name]);
        }
    }
}