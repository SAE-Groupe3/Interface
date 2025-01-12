<?php
require_once '../models/Utilisateur.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $utilisateurModel = new Utilisateur($pdo);
    $utilisateur = $utilisateurModel->verifierIdentifiants($email, $password);

    if ($utilisateur) {
        $_SESSION['utilisateur'] = $utilisateur;
        header('Location: /dashboard');
        exit();
    } else {
        echo "Identifiants incorrects.";
    }
}
