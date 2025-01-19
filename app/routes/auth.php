<?php
session_start();

// Inclure la connexion à la base de données
require_once '../config/db.php';

// Inclure la classe Utilisateur
require_once '../models/Utilisateur.php';

// Instancier le modèle Utilisateur
$utilisateurModel = new Utilisateur($pdo);

// Gestion de l'authentification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    // Vérifiez si un compteur d'échecs existe pour cet email
    if (!isset($_SESSION['failed_attempts'])) {
        $_SESSION['failed_attempts'] = [];
    }

    if (!isset($_SESSION['failed_attempts'][$email])) {
        $_SESSION['failed_attempts'][$email] = ['count' => 0, 'locked_until' => null];
    }

    $attemptData = &$_SESSION['failed_attempts'][$email];

    // Vérifier si l'utilisateur est verrouillé
    if ($attemptData['locked_until'] && time() < $attemptData['locked_until']) {
        $_SESSION['error'] = "Trop de tentatives échouées. Réessayez après " . date('H:i:s', $attemptData['locked_until']);
        header('Location: /login');
        exit;
    }

    // Vérifier les identifiants
    $utilisateur = $utilisateurModel->verifierIdentifiants($email, $password);

    if ($utilisateur) {
        // Récupérer le rôle de l'utilisateur
        $role = $utilisateurModel->getUserRole($utilisateur['id']);

        if (!$role) {
            // Si aucun rôle n'est trouvé, affichez une erreur et redirigez
            $_SESSION['error'] = "Votre compte n'a pas de rôle associé.";
            header('Location: /login');
            exit;
        }

        // Réinitialiser les tentatives si connexion réussie
        $attemptData['count'] = 0;
        $attemptData['locked_until'] = null;

        // Stocker les informations utilisateur dans la session
        $_SESSION['utilisateur'] = [
            'id' => $utilisateur['id'],
            'email' => $utilisateur['email'],
            'role' => $role
        ];

        // Redirection vers le tableau de bord
        header('Location: /dashboard');
        exit;
    } else {
        // Incrémenter les tentatives échouées
        $attemptData['count']++;

        if ($attemptData['count'] >= 5) {
            $attemptData['locked_until'] = time() + (60 * 5); // Verrouillage pendant 5 minutes
            $_SESSION['error'] = "Trop de tentatives échouées. Réessayez après " . date('H:i:s', $attemptData['locked_until']);
        } else {
            $_SESSION['error'] = "Identifiants incorrects. Tentatives restantes : " . (5 - $attemptData['count']);
        }

        header('Location: /login');
        exit;
    }
}
?>
