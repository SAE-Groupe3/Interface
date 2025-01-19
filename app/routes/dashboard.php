<?php
require_once '../config/db.php';
require_once '../models/Stage.php';

// Vérification que l'utilisateur est connecté
if (!isset($_SESSION['utilisateur'])) {
    header("Location: /login");
    exit();
}

// Récupération des informations de l'utilisateur
$utilisateur = $_SESSION['utilisateur'];

// Instanciation du modèle Stage
$stageModel = new Stage($pdo);

// Récupération des notifications pour l'utilisateur connecté
$notifications = $stageModel->getNotifications($utilisateur['id']);

// Inclure la vue du tableau de bord
require_once '../views/dashboard.php';
