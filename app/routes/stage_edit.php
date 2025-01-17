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

// Si la requête est de type POST, c'est une tentative de modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idTuteurPedagogique = (int)$_POST['id_tuteur_pedagogique'];

    // Appeler la méthode assignTuteur() du contrôleur pour mettre à jour le tuteur
    $controller->assignTuteur($idStage, $idTuteurPedagogique);
} else {
    // Si la requête n'est pas POST, afficher la page d'édition du stage
    // Appeler la méthode edit() pour afficher le formulaire d'édition
    $controller->edit($idStage);  // Utiliser la méthode edit() pour afficher le formulaire d'édition
}
?>
