<?php
require_once '../config/db.php';
require_once '../models/Stage.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur'])) {
    header('Location: /login');
    exit();
}

// Créer une instance de Stage
$stageModel = new Stage($pdo);

// Vérification du rôle de l'utilisateur
$utilisateur = $_SESSION['utilisateur'];
$role = $utilisateur['role'];

// Récupérer les stages selon le rôle
if ($role === 'etudiant') {
    // Si c'est un étudiant, récupérer uniquement ses stages
    $stages = $stageModel->getStagesByEtudiantId($utilisateur['id']);
} else {
    // Sinon, récupérer tous les stages
    $stages = $stageModel->getAllStages();
}

// Inclure la vue
require_once '../views/stages/liste.php';
