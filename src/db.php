<?php
class DB{
    public const DB_HOST = 'localhost';
    public const DB_USER = 'root';
    public const DB_PASS = '';
    public const DB_NAME = 'pokedex';
    private static ?PDO $db = null;

    public static function getConexion(){
        if(self::$db === null){
            $db_dsn = 'mysql:host='.self::DB_HOST.';dbname='.self::DB_NAME;
            try{
                self::$db = new PDO($db_dsn, self::DB_USER, self::DB_PASS);
            } catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
            }
        }
        return self::$db;
    }
}