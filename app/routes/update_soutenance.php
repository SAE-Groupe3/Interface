<?php
require_once '../config/db.php';
require_once '../models/Stage.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idStage = (int)$_POST['id_stage'];
    $dateSoutenance = $_POST['date_soutenance'];
    $salleSoutenance = $_POST['salle_soutenance'];

    // Crée une instance du modèle Stage
    $stageModel = new Stage($pdo);

    // Mise à jour de la soutenance
    if ($stageModel->updateSoutenance($idStage, $dateSoutenance, $salleSoutenance)) {
        header('Location: /stage/details?id=' . $idStage);
        exit();
    } else {
        echo "Erreur : Impossible de mettre à jour la soutenance.";
    }
}
