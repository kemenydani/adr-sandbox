<?php

namespace App\Core;

class Cookie
{
    public static function exists($name)
    {
        return array_key_exists($name, $_COOKIE);
    }
    public static function get($name)
    {
        return $_COOKIE[$name];
    }
    public static function put($name, $value, $expiry)
    {
        if(setcookie($name, $value, time() + $expiry, '/'))
        {
           return true;
        }
        return false;
    }
    public static function delete($name)
    {
        self::put($name, '', time() - 1);
    }
}