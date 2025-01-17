<?php
require_once '../config/db.php';
require_once '../models/Stage.php';

// Vérifie que l'utilisateur est connecté et a le rôle approprié
session_start();
if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'admin') {
    header('Location: /login');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idStage = (int)$_POST['id_stage'];
    $idTuteurPedagogique = (int)$_POST['id_tuteur_pedagogique'];

    $stageModel = new Stage($pdo);

    // Appelle la méthode pour assigner le tuteur
    if ($stageModel->assignTuteurPedagogique($idStage, $idTuteurPedagogique)) {
        $_SESSION['message'] = "Le tuteur pédagogique a été assigné avec succès.";
        header("Location: /stage/details?id=$idStage");
        exit();
    } else {
        $_SESSION['message'] = "Erreur lors de l'assignation du tuteur pédagogique.";
        header("Location: /stage/details?id=$idStage");
        exit();
    }
}
