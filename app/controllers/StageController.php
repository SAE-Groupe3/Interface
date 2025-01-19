<?php
require_once '../models/Stage.php';
require_once '../models/Utilisateur.php';

class StageController {
    private $pdo;
    private $stageModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->stageModel = new Stage($pdo);
    }

    /**
     * Afficher les stages en fonction du rôle de l'utilisateur
     */
    public function afficherStages($role, $userId) {
        if ($role === 'Etudiant') {
            $stages = $this->stageModel->getStagesByEtudiantId($userId);
        } elseif ($role === 'Enseignant') {
            $stages = $this->stageModel->getStagesByTuteurPedagogique($userId);
        } elseif ($role === "Tuteur d'Entreprise") {
            $stages = $this->stageModel->getStagesByTuteurEntreprise($userId);
        } else {
            $stages = $this->stageModel->getAllStages();
        }
    
        // Inclure la vue pour afficher la liste des stages
        require_once '../views/stages/liste.php';
    }

    public function getStageModel() {
        return $this->stageModel;
    }

    public function supprimerStage($idStage) {
        if (!is_numeric($idStage)) {
            $_SESSION['error'] = "ID de stage invalide.";
            header("Location: /manage_stages");
            exit();
        }
    
        try {
            $this->stageModel->supprimerStage($idStage);
            $_SESSION['message'] = "Le stage a été supprimé avec succès.";
        } catch (Exception $e) {
            $_SESSION['error'] = "Erreur lors de la suppression du stage : " . $e->getMessage();
        }
    
        header("Location: /manage_stages");
        exit();
    }
    
    public function validateStageRequest($idAction, $isApproved) {
        try {
            $this->stageModel->validateRequest($idAction, $isApproved);
    
            // Récupérer les détails de la demande
            $stage = $this->stageModel->getStageByAction($idAction);
            $userId = $stage['id_etudiant'];
    
            // Créer le message de notification
            $message = $isApproved 
                ? "Votre demande de stage pour la mission '{$stage['mission']}' a été validée."
                : "Votre demande de stage pour la mission '{$stage['mission']}' a été rejetée.";
    
            // Ajouter la notification dans la base de données
            $this->stageModel->addNotification($userId, $message, $isApproved ? 'success' : 'error');
    
            $_SESSION['message'] = "La demande a été " . ($isApproved ? "validée." : "rejetée.");
        } catch (Exception $e) {
            $_SESSION['error'] = "Erreur : " . $e->getMessage();
        }
    
        header("Location: /manage_requests");
        exit();
    }
    
    
    
    /**
     * Afficher les détails d'un stage spécifique
     */
    public function details($idStage) {
        // Vérifier que l'ID est valide
        if (!is_numeric($idStage)) {
            header("Location: /stage");
            exit();
        }

        // Charger les informations du stage
        $stage = $this->stageModel->getStageById($idStage);

        // Vérifier si le stage existe
        if (!$stage) {
            header("Location: /stage");
            exit();
        }

        // Charger la liste des enseignants pour l'assignation si nécessaire
        $enseignants = $this->stageModel->getAllEnseignants();

        // Charger la liste des tuteurs entreprise
        $tuteursEntreprise = $this->stageModel->getAllTuteursEntreprise();

        // Inclure la vue des détails du stage
        require_once '../views/stages/details.php';
    }

    public function gererStages() {
        $stages = $this->stageModel->getAllStages();
        require_once '../views/stages/manage_stages.php';
    }

    /**
     * Assigner un tuteur entreprise à un stage
     */
    public function assignTuteurEntreprise($idStage, $idTuteurEntreprise) {
        if (!is_numeric($idStage) || !is_numeric($idTuteurEntreprise)) {
            $_SESSION['error'] = "ID invalide pour l'assignation du tuteur entreprise.";
            header("Location: /stage/details?id=" . urlencode($idStage));
            exit();
        }

        try {
            $this->stageModel->assignTuteurEntreprise($idStage, $idTuteurEntreprise);
            $_SESSION['message'] = "Tuteur entreprise assigné avec succès.";
        } catch (Exception $e) {
            $_SESSION['error'] = "Erreur lors de l'assignation : " . $e->getMessage();
        }

        header("Location: /stage/details?id=" . urlencode($idStage));
        exit();
    }
}
