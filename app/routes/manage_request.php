<?php
require_once '../config/db.php';
require_once '../models/Stage.php';
require_once '../utils/auth_helpers.php'; // Assurez-vous que ce fichier existe et contient `requireRole`

// Vérification du rôle (Admin requis)
requireRole('Administrateur');

// Créer une instance du modèle Stage
$stageModel = new Stage($pdo);

// Récupérer toutes les demandes de stage
$demandes = $stageModel->getStageRequests();


// Inclure la vue pour afficher les demandes
require_once '../views/manage_requests.php';
