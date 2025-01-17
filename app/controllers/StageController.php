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
    
    public function afficherStages($role, $userId) {
        if ($role === 'Etudiant') {
            $stages = $this->stageModel->getStagesByEtudiantId($userId);
        } elseif ($role === 'Enseignant') {
            $stages = $this->stageModel->getStagesByTuteurPedagogique($userId);
        } else {
            $stages = $this->stageModel->getAllStages();
        }

        require_once '../views/stages/liste.php';
    }
}

?>
