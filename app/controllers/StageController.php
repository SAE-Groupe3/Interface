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
        } else {
            $stages = $this->stageModel->getAllStages();
        }

        // Inclure la vue pour afficher la liste des stages
        require_once '../views/stages/liste.php';
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

        // Inclure la vue des détails du stage
        require_once '../views/stages/details.php';
    }
}
