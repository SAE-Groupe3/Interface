<?php
// Inclure la connexion à la base de données et le modèle Stage
require_once '../config/db.php';
require_once '../models/Stage.php';

// Vérification du rôle (seulement pour les administrateurs)
require_once '../utils/auth_helpers.php';
requireRole('Administrateur');

// Vérifiez que l'ID du stage est présent
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

if (!$id) {
    $_SESSION['error'] = "ID du stage manquant ou invalide.";
    header("Location: /manage_stages");
    exit;
}

try {
    // Instancier le modèle Stage et supprimer le stage
    $stageModel = new Stage($pdo);
    $deleted = $stageModel->deleteStage($id);

    if ($deleted) {
        $_SESSION['success'] = "Stage supprimé avec succès.";
    } else {
        $_SESSION['error'] = "Aucun stage trouvé avec cet ID.";
    }
} catch (Exception $e) {
    $_SESSION['error'] = "Erreur lors de la suppression : " . $e->getMessage();
}

// Redirection vers la page de gestion des stages
header("Location: /manage_stages");
exit;
