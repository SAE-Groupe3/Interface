<?php
class Utilisateur {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function verifierIdentifiants($email, $password) {
        $query = $this->pdo->prepare("
            SELECT id, nom, prenom, email, telephone, login, role, motdepasse
            FROM utilisateur
            WHERE email = :email
        ");
    
        $query->execute(['email' => $email]);
        $utilisateur = $query->fetch(PDO::FETCH_ASSOC);
    
        if ($utilisateur && hash_equals($utilisateur['motdepasse'], crypt($password, $utilisateur['motdepasse']))) {
            // Supprimer le mot de passe des résultats pour des raisons de sécurité
            unset($utilisateur['motdepasse']);
            return $utilisateur;
        }
    
        return false;
    }
    
    public function getAllUtilisateurs() {
        $query = $this->pdo->query("
            SELECT id, nom, prenom, email, role 
            FROM utilisateur
            ORDER BY role, nom
        ");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTuteurs() {
        $query = $this->pdo->query("
            SELECT id, nom, prenom, email, role 
            FROM utilisateur
            WHERE role = 'tuteur'
            ORDER BY nom
        ");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
}

