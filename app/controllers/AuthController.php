<?php

require_once '../models/Stage.php';
require_once '../models/Utilisateur.php';

class AuthController
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = htmlspecialchars(trim($_POST['email']));
            $password = htmlspecialchars(trim($_POST['password']));
    
            $user = Utilisateur::findByEmail($email);
    
            if ($user && password_verify($password, $user['motdepasse'])) {
                // Déterminer le rôle
                $role = Utilisateur::getUserRole($user['id']);
                if ($role) {
                    session_start();
                    $_SESSION['user_role'] = $role;
                    $_SESSION['utilisateur'] = $user;
    
                    // Redirige vers le tableau de bord
                    header('Location: /dashboard');
                    exit();
                } else {
                    // Aucun rôle trouvé
                    $_SESSION['error'] = "Votre compte n'a pas de rôle associé.";
                    header('Location: /login');
                    exit();
                }
            } else {
                // Identifiants invalides
                $_SESSION['error'] = "Identifiants incorrects.";
                header('Location: /login');
                exit();
            }
        }
    }
    

    public function logout()
    {
        // Détruire la session
        session_start();
        session_destroy();
        header('Location: /login');
        exit;
    }
}