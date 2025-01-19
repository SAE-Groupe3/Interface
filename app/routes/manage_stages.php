<?php
require_once '../config/db.php';
require_once '../models/Stage.php';
require_once '../controllers/StageController.php';

// Vérifiez si l'utilisateur est connecté et s'il a le rôle d'administrateur
if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'Administrateur') {
    header("Location: /login");
    exit();
}

// Initialisez le contrôleur et récupérez les données des stages
$controller = new StageController($pdo);
$stages = $controller->getStageModel()->getAllStages();


// Incluez la vue de gestion des stages
require_once '../views/stages/manage_stages.php';
?>
