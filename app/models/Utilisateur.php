<?php
class Utilisateur {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function verifierIdentifiants($email, $password) {
        $query = $this->pdo->prepare("
            SELECT id, nom, prenom, email, telephone, login, role 
            FROM utilisateur 
            WHERE email = :email 
            AND motdepasse = crypt(:password, motdepasse)
        ");
    
        $query->execute([
            'email' => $email,
            'password' => $password
        ]);
    
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    
    
}
