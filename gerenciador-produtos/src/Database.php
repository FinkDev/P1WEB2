<?php
class Database {
    private $pdo;

    public function __construct($dbFile) {
        try {
            $this->pdo = new PDO("sqlite:" . $dbFile);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
            exit;
        }
    }

    public function getConnection() {
        return $this->pdo; 
    }

    public function query($query) {
        return $this->pdo->query($query);
    }

    public function prepare($query) {
        return $this->pdo->prepare($query);
    }

    public function getPdo() {
        return $this->pdo;
    }

    public function lastInsertId() {
        return $this->pdo->lastInsertId(); 
    }
}