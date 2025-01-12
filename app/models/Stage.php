<?php
class Stage {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Récupérer tous les stages
    public function getAllStages() {
        $query = $this->pdo->query("
            SELECT Stage.id_stage, Utilisateur.nom AS etudiant_nom, Stage.mission, Stage.date_debut, Stage.date_fin 
            FROM Stage
            JOIN Utilisateur ON Stage.id_etudiant = Utilisateur.id
        ");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les stages d'un étudiant spécifique
    public function getStagesByEtudiantId($idEtudiant) {
        $query = $this->pdo->prepare("
            SELECT id_stage, mission, date_debut, date_fin 
            FROM Stage
            WHERE id_etudiant = :idEtudiant
        ");
        $query->execute(['idEtudiant' => $idEtudiant]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
        
    }
    public function getStageById($idStage) {
        $query = $this->pdo->prepare("
            SELECT Stage.id_stage, Utilisateur.nom AS etudiant_nom, Stage.mission, Stage.date_debut, Stage.date_fin, 
                   Utilisateur.email AS etudiant_email, Stage.date_soutenance, Stage.salle_soutenance 
            FROM Stage
            JOIN Utilisateur ON Stage.id_etudiant = Utilisateur.id
            WHERE Stage.id_stage = :idStage
        ");
        $query->execute(['idStage' => $idStage]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}

