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

    public static function count($table, array $params = [])
    {
        $db = self::connect();
        $where = array_map(function($key) {
            return $key.'=?';
        }, array_keys($params));

        if ($where) {
            $query = $db->prepare('SELECT COUNT(id) AS total FROM '.$table.' WHERE '.implode($where, ' AND '));
        } else {
            $query = $db->prepare('SELECT COUNT(id) AS total FROM '.$table);
        }
        $query->execute(array_values($params));
        return (int)$query->fetch(PDO::FETCH_ASSOC)['total'];
    }
}
