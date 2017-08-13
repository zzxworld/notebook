<?php
class DB
{
    protected static $connection = null;

    public static function connect()
    {
        try {
            if (!isset(self::$connection)) {
                self::$connection = new PDO('sqlite:'.APP_ROOT.'/'.Config::get('db_name'), null, null, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]);
            }
            return self::$connection;
        } catch (Exception $e) {
            die('can not connect to db.');
        }
    }

    public static function prepare($sql)
    {
        $db = self::connect();
        return $db->prepare($sql);
    }

    public static function lastInsertId()
    {
        $db = self::connect();
        return $db->lastInsertId();
    }
}
