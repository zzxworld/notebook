<?php

class Config
{
    protected static $data = [];

    public static function set($name, $value)
    {
        self::$data[$name] = $value;
    }

    public static function get($name, $default=null)
    {
        return findArray(self::$data, $name, $default);
    }
}
