<?php
require_once '../models/Stage.php';

class StageController {
    private $stageModel;

    public function __construct($pdo) {
        $this->stageModel = new Stage($pdo);
    }

    public function afficherStages() {
        $stages = $this->stageModel->getAllStages();
        require '../views/stages/liste.php';
    }
}
?>
