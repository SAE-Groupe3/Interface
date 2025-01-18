<?php
require_once '../config/db.php';
require_once '../models/Stage.php';

// Vérification que l'utilisateur est connecté et est un administrateur
if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'Administrateur') {
    header("Location: /login");
    exit();
}

// Récupération des paramètres de l'URL
$idAction = $_GET['id'] ?? null;
$action = $_GET['action'] ?? null;

if ($idAction && $action) {
    $stageModel = new Stage($pdo);

    try {
        if ($action === 'validate') {
            $stageModel->validateRequest($idAction);
            $_SESSION['message'] = "La demande de stage a été validée avec succès.";
        } elseif ($action === 'reject') {
            $stageModel->rejectRequest($idAction);
            $_SESSION['message'] = "La demande de stage a été rejetée avec succès.";
        } else {
            $_SESSION['error'] = "Action non reconnue.";
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Une erreur est survenue : " . $e->getMessage();
    }
} else {
    $_SESSION['error'] = "Paramètres invalides pour cette action.";
}

// Redirection vers la page des demandes
header("Location: /manage_requests");
exit();
