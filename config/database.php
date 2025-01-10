<?php
// config/database.php

class Database {
    private $host = "localhost";
    private $db_name = "gestion_stages";
    private $username = "postgres";
    private $password = "ton_mot_de_passe";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("pgsql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Erreur de connexion : " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
