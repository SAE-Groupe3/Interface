<?php
require_once '../config/db.php';
require_once '../models/Stage.php';

if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'Administrateur') {
    header("Location: /login");
    exit();
}

$idStage = $_GET['id'] ?? null;

if ($idStage && is_numeric($idStage)) {
    $stageModel = new Stage($pdo);

    try {
        $stageModel->supprimerStage($idStage);
        $_SESSION['message'] = "Stage supprimé avec succès.";
    } catch (Exception $e) {
        $_SESSION['error'] = "Erreur lors de la suppression : " . $e->getMessage();
    }
} else {
    $_SESSION['error'] = "ID de stage invalide.";
}

header("Location: /manage_stages");
exit();
