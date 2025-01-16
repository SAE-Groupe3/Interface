<?php
require_once '../config/db.php';
require_once '../models/Utilisateur.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    $utilisateur = new Utilisateur($pdo);
    $utilisateurData = $utilisateur->verifierIdentifiants($email, $password);

    if ($utilisateurData) {
        $_SESSION['utilisateur'] = $utilisateurData;
        header('Location: /dashboard');
        exit();
    } else {
        header('Location: /login?error=true');
        exit();
    }
    
}
