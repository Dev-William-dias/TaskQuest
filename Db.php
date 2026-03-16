<?php

require_once("Utill.php");

class Db {

    private static ?Db $instance = null;
    private PDO $pdo;

    private string $host = 'localhost';
    private string $dbname = 'task_manager';
    private string $user = 'developer';
    private string $pass = '1234567';

    private function __construct() {
        try {
            $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4", $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            Utill::logError("Db Erro: ".$e->getMessage());
        }
    }

    public static function getConnection(): PDO {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->pdo;
    }
}
