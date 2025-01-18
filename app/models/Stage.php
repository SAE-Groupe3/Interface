<?php

class Stage {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllEnseignants() {
        $query = $this->pdo->query("
            SELECT id, nom, prenom, email
            FROM Utilisateur
            JOIN Enseignant ON Utilisateur.id = Enseignant.id_enseignant
        ");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function getAllStages() {
        $query = $this->pdo->query("
            SELECT 
                Stage.id_stage, 
                Stage.mission, 
                Stage.date_debut, 
                Stage.date_fin, 
                CONCAT(Utilisateur.nom, ' ', Utilisateur.prenom) AS etudiant
            FROM Stage
            JOIN Utilisateur ON Stage.id_etudiant = Utilisateur.id
            WHERE Stage.id_stage IN (
                SELECT Id_Stage 
                FROM Action 
                WHERE Id_TypeAction = (
                    SELECT Id_TypeAction FROM TypeAction WHERE libelle = 'Validation de Stage'
                )
            )
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
                CONCAT(Utilisateur.nom, ' ', Utilisateur.prenom) AS etudiant
            FROM Stage
            JOIN Utilisateur ON Stage.id_etudiant = Utilisateur.id
            WHERE Stage.id_etudiant = :id_etudiant
            AND Stage.id_stage IN (
                SELECT Id_Stage 
                FROM Action 
                WHERE Id_TypeAction = (
                    SELECT Id_TypeAction FROM TypeAction WHERE libelle = 'Validation de Stage'
                )
            )
        ");
        $query->execute(['id_etudiant' => $idEtudiant]);
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

    public function createStage($idEtudiant, $mission, $dateDebut, $dateFin) {
        // Créer le stage avec un statut "en attente"
        $query = $this->pdo->prepare("
            INSERT INTO Stage (id_etudiant, mission, date_debut, date_fin)
            VALUES (:id_etudiant, :mission, :date_debut, :date_fin)
        ");
        $query->execute([
            'id_etudiant' => $idEtudiant,
            'mission' => $mission,
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
        ]);
    
        $idStage = $this->pdo->lastInsertId();
    
        // Créer une action associée à la demande
        $this->addAction($idStage, 1); // 1 = ID du type d'action "Demande de Stage"
        return $idStage;
    }
    
    public function addAction($idStage, $idTypeAction) {
        // Vérifiez si l'action existe déjà
        $query = $this->pdo->prepare("
            SELECT COUNT(*) 
            FROM Action 
            WHERE Id_Stage = :idStage AND Id_TypeAction = :idTypeAction
        ");
        $query->execute([
            'idStage' => $idStage,
            'idTypeAction' => $idTypeAction
        ]);
    
        if ($query->fetchColumn() > 0) {
            // Si une action existe déjà, ne rien faire
            return;
        }
    
        // Insérez une nouvelle action
        $query = $this->pdo->prepare("
            INSERT INTO Action (Id_Stage, Id_TypeAction, date_realisation)
            VALUES (:idStage, :idTypeAction, NOW())
        ");
        $query->execute([
            'idStage' => $idStage,
            'idTypeAction' => $idTypeAction
        ]);
    }
    
    

    public function getStageRequests() {
        $query = $this->pdo->query("
            SELECT 
                Action.Id_Action,
                Stage.id_stage,
                Stage.mission,
                Stage.date_debut,
                Stage.date_fin,
                CONCAT(Utilisateur.nom, ' ', Utilisateur.prenom) AS etudiant
            FROM Action
            JOIN Stage ON Action.Id_Stage = Stage.Id_Stage
            JOIN Utilisateur ON Stage.id_etudiant = Utilisateur.id
            WHERE Action.Id_TypeAction = (
                SELECT Id_TypeAction FROM TypeAction WHERE libelle = 'Demande de Stage'
            )
        ");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function validateRequest($idAction) {
        $query = $this->pdo->prepare("
            UPDATE Action
            SET Id_TypeAction = (
                SELECT Id_TypeAction FROM TypeAction WHERE libelle = 'Validation de Stage'
            )
            WHERE Id_Action = :id_action
        ");
        $query->execute(['id_action' => $idAction]);
    }
    
    public function rejectRequest($idAction) {
        $query = $this->pdo->prepare("
            DELETE FROM Action
            WHERE Id_Action = :id_action
        ");
        $query->execute(['id_action' => $idAction]);
    }
}


?>
