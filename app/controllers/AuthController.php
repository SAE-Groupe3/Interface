<?php

require_once '../models/Utilisateur.php';

class AuthController {
    private $utilisateurModel;

    public function __construct($pdo) {
        $this->utilisateurModel = new Utilisateur($pdo);
    }

    public function login() {
        session_start();

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

            // Vérifiez si l'utilisateur est verrouillé
            if ($attemptData['locked_until'] && time() < $attemptData['locked_until']) {
                $_SESSION['error'] = "Trop de tentatives échouées. Réessayez après " . date('H:i:s', $attemptData['locked_until']);
                header('Location: /login');
                exit;
            }

            // Vérifiez les identifiants
            $utilisateur = $this->utilisateurModel->verifierIdentifiants($email, $password);

            if ($utilisateur) {
                // Réinitialiser les tentatives en cas de succès
                $attemptData['count'] = 0;
                $attemptData['locked_until'] = null;

                $_SESSION['utilisateur'] = [
                    'id' => $utilisateur['id'],
                    'email' => $utilisateur['email']
                ];

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
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: /login');
        exit;
    }
}
?>
