<?php
// models/Utilisateur.php

class Utilisateur {
    private $conn;
    private $table_name = "Utilisateur";

    public $id;
    public $nom;
    public $prenom;
    public $email;
    public $telephone;
    public $login;
    public $motdepasse;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>
