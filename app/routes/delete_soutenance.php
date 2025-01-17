<?php
require_once '../config/db.php';
require_once '../models/Stage.php';

if (isset($_GET['id_stage'])) {
    $idStage = (int)$_GET['id_stage'];

    // Crée une instance du modèle Stage
    $stageModel = new Stage($pdo);

    // Suppression de la soutenance
    if ($stageModel->deleteSoutenance($idStage)) {
        header('Location: /stage/details?id=' . $idStage);
        exit();
    } else {
        echo "Erreur : Impossible de supprimer la soutenance.";
    }
}
