<?php
// Assurez-vous que la session est démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inclure les dépendances nécessaires
require_once '../models/Utilisateur.php'; // Modifiez le chemin selon l'organisation de vos fichiers

// Créer une instance de la classe Utilisateur
$utilisateurModel = new Utilisateur($pdo);

// Vérifier si les données ont été envoyées via le formulaire (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Valider les identifiants
    $utilisateur = $utilisateurModel->verifierIdentifiants($email, $password);

    if ($utilisateur) {
        // L'utilisateur est authentifié avec succès
        $_SESSION['utilisateur'] = [
            'id' => $utilisateur['id'],
            'email' => $utilisateur['email'],
            'role' => $utilisateurModel->getUserRole($utilisateur['id'])
        ];

        // Rediriger l'utilisateur vers la page d'accueil ou une autre page
        header('Location: /dashboard'); // Remplacez par la page de destination
        exit;
    } else {
        // Identifiants invalides
        $messageErreur = "Email ou mot de passe incorrect.";
    }
}
?>
