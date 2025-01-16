<?php
require_once '../config/db.php';
require_once '../models/Utilisateur.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur'])) {
    header('Location: /login');
    exit();
}

// Créer une instance de Utilisateur
$utilisateurModel = new Utilisateur($pdo);

// Vérification du rôle de l'utilisateur connecté
$utilisateur = $_SESSION['utilisateur'];
$role = $utilisateur['role'];

if ($role === 'etudiant') {
    // Si c'est un étudiant, récupérer uniquement les tuteurs
    $utilisateurs = $utilisateurModel->getTuteurs();
} else {
    // Sinon, récupérer tous les utilisateurs
    $utilisateurs = $utilisateurModel->getAllUtilisateurs();
}

// Inclure la vue
require_once '../views/utilisateurs/liste.php';
        