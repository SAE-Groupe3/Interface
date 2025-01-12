<?php
require_once '../config/db.php';
require_once '../models/Stage.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur'])) {
    header('Location: /login');
    exit();
}

// Vérifier si un id de stage est fourni dans l'URL
if (!isset($_GET['id'])) {
    echo "Erreur : Aucun stage spécifié.";
    exit();
}

$idStage = (int)$_GET['id'];

// Créer une instance de Stage
$stageModel = new Stage($pdo);

// Récupérer les détails du stage
$stage = $stageModel->getStageById($idStage);

if (!$stage) {
    echo "Erreur : Stage introuvable.";
    exit();
}

// Inclure la vue
require_once '../views/stages/details.php';
