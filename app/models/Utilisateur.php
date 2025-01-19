<?php
class Utilisateur {
    private $pdo;

    // Constructeur pour injecter PDO
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Méthode pour vérifier les identifiants
    

        // Méthode pour trouver un utilisateur par email
        public static function findByEmail($email, $pdo) {
            $query = $pdo->prepare("SELECT id, email, motdepasse FROM Utilisateur WHERE email = :email");
            $query->execute(['email' => $email]);
            return $query->fetch(PDO::FETCH_ASSOC);
        }
    
        // Vérifier les identifiants

        public function verifierIdentifiants($email, $password) {
            $query = $this->pdo->prepare("SELECT id, email, motdepasse FROM Utilisateur WHERE email = :email");
            $query->execute(['email' => $email]);
            $utilisateur = $query->fetch(PDO::FETCH_ASSOC);
    
            if ($utilisateur && password_verify($password, $utilisateur['motdepasse'])) {
                return $utilisateur;
            }
            return false;
        }
        
        // Récupérer le rôle de l'utilisateur
        public function getUserRole($userId) {
            $roles = ['Administrateur', 'Etudiant', 'Enseignant', 'Tuteur_Entreprise'];
            foreach ($roles as $table) {
                $stmt = $this->pdo->prepare("SELECT 1 FROM $table WHERE id_$table = :userId");
                $stmt->execute(['userId' => $userId]);
                if ($stmt->fetch()) {
                    return $table; // Retourne le nom de la table comme rôle
                }
            }
            return null;
        }
}

?>
