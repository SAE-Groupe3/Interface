<?php
require_once '../config/db.php';
require_once '../models/Stage.php';
require_once '../models/Utilisateur.php';
require_once '../controllers/StageController.php';  // Inclure le contrôleur

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

// Récupérer l'ID du stage depuis l'URL
$idStage = (int)$_GET['id'];

// Créer une instance du contrôleur StageController
$controller = new StageController($pdo);

// Afficher les détails du stage
$controller->details($idStage);  // Appeler la méthode details() pour afficher les informations du stage
?>
