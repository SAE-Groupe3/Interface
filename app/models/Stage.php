<?php

class Stage {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllStages() {
        $query = $this->pdo->query("
            SELECT 
                Stage.id_stage,
                Stage.mission,
                Stage.date_debut,
                Stage.date_fin,
                CONCAT(e.nom, ' ', e.prenom) AS etudiant,
                CONCAT(t.nom, ' ', t.prenom) AS tuteur_pedagogique,
                CONCAT(te.nom, ' ', te.prenom) AS tuteur_entreprise
            FROM Stage
            LEFT JOIN Utilisateur e ON Stage.id_etudiant = e.id
            LEFT JOIN Utilisateur t ON Stage.id_tuteur_pedagogique = t.id
            LEFT JOIN Utilisateur te ON Stage.id_tuteur_entreprise = te.id
        ");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStagesByEtudiantId($idEtudiant) {
        $query = $this->pdo->prepare("
            SELECT 
                Stage.id_stage,
                Stage.mission,
                Stage.date_debut,
                Stage.date_fin,
                CONCAT(e.nom, ' ', e.prenom) AS etudiant,
                CONCAT(t.nom, ' ', t.prenom) AS tuteur_pedagogique,
                CONCAT(te.nom, ' ', te.prenom) AS tuteur_entreprise
            FROM Stage
            LEFT JOIN Utilisateur e ON Stage.id_etudiant = e.id
            LEFT JOIN Utilisateur t ON Stage.id_tuteur_pedagogique = t.id
            LEFT JOIN Utilisateur te ON Stage.id_tuteur_entreprise = te.id
            WHERE Stage.id_etudiant = :idEtudiant
        ");
        $query->execute(['idEtudiant' => $idEtudiant]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les stages supervisés par un tuteur pédagogique
    public function getStagesByTuteurPedagogique($idTuteur) {
        $query = $this->pdo->prepare("
            SELECT 
                Stage.id_stage,
                Stage.mission,
                Stage.date_debut,
                Stage.date_fin,
                CONCAT(e.nom, ' ', e.prenom) AS etudiant,
                CONCAT(t.nom, ' ', t.prenom) AS tuteur_pedagogique,
                CONCAT(te.nom, ' ', te.prenom) AS tuteur_entreprise
            FROM Stage
            LEFT JOIN Utilisateur e ON Stage.id_etudiant = e.id
            LEFT JOIN Utilisateur t ON Stage.id_tuteur_pedagogique = t.id
            LEFT JOIN Utilisateur te ON Stage.id_tuteur_entreprise = te.id
            WHERE Stage.id_tuteur_pedagogique = :idTuteur
        ");
        $query->execute(['idTuteur' => $idTuteur]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    

    // Récupérer les détails d'un stage spécifique
    public function getStageById($idStage) {
        $query = $this->pdo->prepare("
            SELECT 
                Stage.id_stage, 
                Stage.id_tuteur_pedagogique, 
                etudiant.nom AS etudiant_nom, 
                etudiant.prenom AS etudiant_prenom, 
                etudiant.email AS etudiant_email, 
                tuteur.nom AS tuteur_nom, 
                tuteur.prenom AS tuteur_prenom, 
                tuteur.email AS tuteur_email, 
                Stage.mission, 
                Stage.date_debut, 
                Stage.date_fin, 
                Stage.date_soutenance, 
                Stage.salle_soutenance
            FROM Stage
            JOIN Utilisateur AS etudiant ON Stage.id_etudiant = etudiant.id
            LEFT JOIN Utilisateur AS tuteur ON Stage.id_tuteur_pedagogique = tuteur.id
            WHERE Stage.id_stage = :idStage
        ");
        $query->execute(['idStage' => $idStage]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}

?>
