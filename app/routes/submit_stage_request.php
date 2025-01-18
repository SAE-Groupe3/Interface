<?php
require_once '../config/db.php';
require_once '../models/Stage.php';

if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'Etudiant') {
    header("Location: /login");
    exit();
}

$mission = $_POST['mission'] ?? null;
$date_debut = $_POST['date_debut'] ?? null;
$date_fin = $_POST['date_fin'] ?? null;
$id_etudiant = $_SESSION['utilisateur']['id'];

if (!$mission || !$date_debut || !$date_fin) {
    echo "Tous les champs sont obligatoires.";
    exit();
}

try {
    $stageModel = new Stage($pdo);
    // Créer un nouveau stage
    $idStage = $stageModel->createStage($id_etudiant, $mission, $date_debut, $date_fin);

    // Ajouter une action uniquement si elle n'existe pas déjà
    $stageModel->addAction($idStage, 1); // TypeAction 1 = Demande de Stage

    $_SESSION['message'] = "Votre demande de stage a été soumise avec succès.";
    header("Location: /stage");
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
