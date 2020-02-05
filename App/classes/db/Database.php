<?php

namespace Db;

class Database
{
    private static $host = '127.0.0.1';
    private static $dbName = 'bank';
    private static $username = 'root';
    private static $password = 'gunnahr';

    private static function connect()
    {
        try {
            $dataSourceName = 'mysql:host='.self::$host.';dbname='.self::$dbName;
            $pdo = new \PDO($dataSourceName, self::$username, self::$password);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            return $pdo;
        } catch (\PDOException $e) {
            echo 'Connection failed'.$e->getMessage();
        }
    }

    public static function getUser($params = array())
    {
        $query = 'SELECT * FROM users WHERE username = ?';
        $stmt = self::connect()->prepare($query);
        $stmt->execute($params);
        $data = $stmt->fetchAll();

        return $data;
    }

    public static function getTransactions($params = array())
    {
        $doubleParams = array($params[0], $params[0]);
        $query = 'SELECT * FROM transactions WHERE from_account = ? OR to_account = ?';
        $stmt = self::connect()->prepare($query);
        $stmt->execute($doubleParams);
        $data = $stmt->fetchAll();

        return $data;
    }

    public static function getBalance($params = array())
    {
        $query = 'SELECT v.balance, a.currency FROM vw_users as v
                     INNER JOIN account as a ON  a.user_id = v.account_id 
                WHERE a.user_id = ?';
        $stmt = self::connect()->prepare($query);
        $stmt->execute($params);
        $data = $stmt->fetch();

        return $data;
    }
}
