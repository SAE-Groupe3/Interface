<?php
require_once '../config/db.php';
require_once '../models/Stage.php';
require_once '../controllers/StageController.php';

// Vérification que l'utilisateur est connecté et est un administrateur
if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'Administrateur') {
    $_SESSION['error'] = "Accès refusé. Vous devez être connecté en tant qu'administrateur.";
    header("Location: /login");
    exit();
}

// Debug : Afficher les paramètres reçus
$idAction = $_GET['id'] ?? null;
$action = $_GET['action'] ?? null;
error_log("validate_request.php : Requête reçue avec idAction = " . print_r($idAction, true) . " et action = " . print_r($action, true));

if ($idAction && $action) {
    try {
        // Initialisation du modèle et du contrôleur
        $stageModel = new Stage($pdo);
        $controller = new StageController($pdo);

        // Récupérer les informations de la demande
        $demande = $stageModel->getStageByAction($idAction);
        error_log("Demande récupérée : " . print_r($demande, true));

        if (!$demande) {
            throw new Exception("Aucune demande associée à l'action $idAction.");
        }

        // Traiter l'action
        if ($action === 'validate') {
            $controller->validateStageRequest($idAction, true);
        } elseif ($action === 'reject') {
            $controller->validateStageRequest($idAction, false);
        } else {
            $_SESSION['error'] = "Action non reconnue.";
            error_log("Action inconnue : $action");
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Erreur lors du traitement : " . $e->getMessage();
        error_log("Erreur : " . $e->getMessage());
    }
} else {
    $_SESSION['error'] = "Paramètres invalides.";
    error_log("Paramètres manquants ou invalides : idAction = $idAction, action = $action");
}

// Redirection vers la page des demandes
header("Location: /manage_requests");
exit();
