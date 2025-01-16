<?php
require_once '../config/db.php';
require_once '../models/Utilisateur.php';


if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}
if (!isset($_SESSION['last_attempt_time'])) {
    $_SESSION['last_attempt_time'] = time();
}

// Verrouillage après 5 tentatives
if ($_SESSION['login_attempts'] >= 5) {
    $timeSinceLastAttempt = time() - $_SESSION['last_attempt_time'];
    if ($timeSinceLastAttempt < 300) { // 300 secondes = 5 minutes
        die("Trop de tentatives. Réessayez dans " . (300 - $timeSinceLastAttempt) . " secondes.");
    } else {
        $_SESSION['login_attempts'] = 0; // Réinitialiser après 5 minutes
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    $utilisateur = new Utilisateur($pdo);
    $utilisateurData = $utilisateur->verifierIdentifiants($email, $password);

    if ($utilisateurData) {
        // Connexion réussie
        $_SESSION['utilisateur'] = $utilisateurData;
        $_SESSION['login_attempts'] = 0; // Réinitialiser les tentatives après succès
        header('Location: /dashboard');
        exit();
    } else {
        // Échec de connexion
        $_SESSION['login_attempts']++;
        $_SESSION['last_attempt_time'] = time();
        $maxAttempts = 5; // Nombre maximum de tentatives
        $remainingAttempts = $maxAttempts - $_SESSION['login_attempts'];
        
        header("Location: /login?error=true&remaining=$remainingAttempts");
        exit();
    }
    
    
}



