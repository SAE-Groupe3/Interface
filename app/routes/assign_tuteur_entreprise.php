<?php
require_once '../config/db.php';
require_once '../models/Stage.php';

if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'Administrateur') {
    header("Location: /login");
    exit();
}

$idStage = $_POST['id_stage'] ?? null;
$idTuteurEntreprise = $_POST['id_tuteur_entreprise'] ?? null;

if ($idStage && $idTuteurEntreprise) {
    try {
        $stageModel = new Stage($pdo);
        $stageModel->assignTuteurEntreprise($idStage, $idTuteurEntreprise);
        $_SESSION['message'] = "Tuteur entreprise assigné avec succès.";
    } catch (Exception $e) {
        $_SESSION['error'] = "Erreur : " . $e->getMessage();
    }
}

header("Location: /stage/details?id=" . urlencode($idStage));
exit();
