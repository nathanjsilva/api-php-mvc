<?php

namespace App\DB;

use PDO;
use PDOException;
use Utils\ExceptionsHandler;

class DBConnection
{
    # Variável que guarda a conexão PDO.
    protected static ?PDO $db = null;

    # Private construct - garante que a classe só possa ser instanciada internamente.
    private function __construct()
    {
        try {
            self::$db = new PDO(DB_DRIVER . ':host=' . DB_HOST . '; dbname=' . DB_NAME, DB_USER, DB_PASS);
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$db->exec('SET NAMES utf8');
        } catch (PDOException $e) {
            (new ExceptionsHandler($e, 'E000-003', 500))->_print();
        }
    }

    /**
     * Returns a singloton connection with database
     * @return \PDO
     */
    public static function connect()
    {
        if (self::$db === null) new DBConnection();
        return self::$db;
    }
}
