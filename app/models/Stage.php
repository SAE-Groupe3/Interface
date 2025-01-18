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
    

        // Supprimer les stages rejetés
    public function deleteRejectedStages() {
        $query = $this->pdo->prepare("
            DELETE FROM Stage
            WHERE id_stage IN (
                SELECT Id_Stage
                FROM Action
                WHERE Id_TypeAction = (
                    SELECT Id_TypeAction
                    FROM TypeAction
                    WHERE libelle = 'Rejet de Stage'
                )
            )
        ");
        $query->execute();
    }
    public function getAllStages() {
        $query = $this->pdo->prepare("
            SELECT 
                Stage.id_stage, 
                Stage.mission, 
                Stage.date_debut, 
                Stage.date_fin, 
                CONCAT(etudiant.nom, ' ', etudiant.prenom) AS etudiant,
                COALESCE(CONCAT(tuteur_pedagogique.nom, ' ', tuteur_pedagogique.prenom), 'Non assigné') AS tuteur_pedagogique,
                COALESCE(CONCAT(tuteur_entreprise.nom, ' ', tuteur_entreprise.prenom), 'Non assigné') AS tuteur_entreprise
            FROM Stage
            JOIN Utilisateur AS etudiant ON Stage.id_etudiant = etudiant.id
            LEFT JOIN Utilisateur AS tuteur_pedagogique ON Stage.id_tuteur_pedagogique = tuteur_pedagogique.id
            LEFT JOIN Utilisateur AS tuteur_entreprise ON Stage.id_tuteur_entreprise = tuteur_entreprise.id
            WHERE Stage.id_stage IN (
                SELECT Id_Stage 
                FROM Action 
                WHERE Id_TypeAction = (
                    SELECT Id_TypeAction FROM TypeAction WHERE libelle = 'Validation de Stage'
                )
            )
        ");
    
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    

// Récupérer les stages d'un étudiant spécifique
// Récupérer les stages d'un étudiant spécifique
// Récupérer les stages d'un étudiant spécifique
public function getStagesByEtudiantId($idEtudiant) {
    $query = $this->pdo->prepare("
        SELECT 
            Stage.id_stage,
            Stage.mission,
            Stage.date_debut,
            Stage.date_fin,
            CONCAT(e.nom, ' ', e.prenom) AS etudiant,
            CASE 
                WHEN t.id IS NOT NULL THEN CONCAT(t.nom, ' ', t.prenom)
                ELSE 'Non attribué'
            END AS tuteur_pedagogique,
            CASE 
                WHEN te.id IS NOT NULL THEN CONCAT(te.nom, ' ', te.prenom)
                ELSE 'Non attribué'
            END AS tuteur_entreprise
        FROM Stage
        LEFT JOIN Utilisateur e ON Stage.id_etudiant = e.id
        LEFT JOIN Utilisateur t ON Stage.id_tuteur_pedagogique = t.id
        LEFT JOIN Utilisateur te ON Stage.id_tuteur_entreprise = te.id
        WHERE Stage.id_etudiant = :idEtudiant
          AND Stage.id_stage IN (
              SELECT Id_Stage 
              FROM Action 
              WHERE Id_TypeAction = (
                  SELECT Id_TypeAction 
                  FROM TypeAction 
                  WHERE libelle = 'Validation de Stage'
              )
          )
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
            CASE 
                WHEN t.id IS NOT NULL THEN CONCAT(t.nom, ' ', t.prenom)
                ELSE 'Non attribué'
            END AS tuteur_pedagogique,
            CASE 
                WHEN te.id IS NOT NULL THEN CONCAT(te.nom, ' ', te.prenom)
                ELSE 'Non attribué'
            END AS tuteur_entreprise
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
                Stage.id_tuteur_entreprise,
                etudiant.nom AS etudiant_nom, 
                etudiant.prenom AS etudiant_prenom, 
                etudiant.email AS etudiant_email, 
                tuteur.nom AS tuteur_nom, 
                tuteur.prenom AS tuteur_prenom, 
                tuteur.email AS tuteur_email, 
                entreprise.nom AS tuteur_entreprise_nom,
                entreprise.prenom AS tuteur_entreprise_prenom,
                entreprise.email AS tuteur_entreprise_email,
                Stage.mission, 
                Stage.date_debut, 
                Stage.date_fin, 
                Stage.date_soutenance, 
                Stage.salle_soutenance
            FROM Stage
            JOIN Utilisateur AS etudiant ON Stage.id_etudiant = etudiant.id
            LEFT JOIN Utilisateur AS tuteur ON Stage.id_tuteur_pedagogique = tuteur.id
            LEFT JOIN Utilisateur AS entreprise ON Stage.id_tuteur_entreprise = entreprise.id
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
    
    // Rejeter une demande de stage
    public function rejectRequest($idStage) {
        // Ajouter une action de rejet
        $query = $this->pdo->prepare("
            INSERT INTO Action (Id_Stage, Id_TypeAction, date_realisation)
            VALUES (:idStage, (SELECT Id_TypeAction FROM TypeAction WHERE libelle = 'Rejet de Stage'), NOW())
        ");
        $query->execute(['idStage' => $idStage]);

        // Supprimer les stages rejetés
        $this->deleteRejectedStages();
    }

    public function assignTuteurPedagogique($idStage, $idTuteurPedagogique) {
        try {
            // Vérifiez si le stage existe
            $query = $this->pdo->prepare("SELECT COUNT(*) FROM Stage WHERE id_stage = :idStage");
            $query->execute(['idStage' => $idStage]);
    
            if ($query->fetchColumn() == 0) {
                throw new Exception("Le stage spécifié n'existe pas.");
            }
    
            // Mettez à jour le tuteur pédagogique pour ce stage
            $query = $this->pdo->prepare("
                UPDATE Stage
                SET id_tuteur_pedagogique = :idTuteurPedagogique
                WHERE id_stage = :idStage
            ");
            $query->execute([
                'idTuteurPedagogique' => $idTuteurPedagogique,
                'idStage' => $idStage
            ]);
        } catch (Exception $e) {
            // Gérez les erreurs et relancez-les pour le gestionnaire d'erreurs supérieur
            throw new Exception("Erreur lors de l'assignation du tuteur pédagogique : " . $e->getMessage());
        }
    }

    public function getAllTuteursEntreprise() {
        $query = $this->pdo->query("
            SELECT 
                Utilisateur.id, 
                Utilisateur.nom, 
                Utilisateur.prenom, 
                Utilisateur.email 
            FROM Utilisateur
            JOIN Tuteur_Entreprise ON Utilisateur.id = Tuteur_Entreprise.id_tuteur_entreprise
        ");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function assignTuteurEntreprise($idStage, $idTuteurEntreprise) {
        $query = $this->pdo->prepare("
            UPDATE Stage
            SET id_tuteur_entreprise = :idTuteurEntreprise
            WHERE id_stage = :idStage
        ");
        $query->execute([
            'idTuteurEntreprise' => $idTuteurEntreprise,
            'idStage' => $idStage
        ]);
    }
    
    
}


?>
