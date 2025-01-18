<?php
require_once '../config/db.php';
require_once '../controllers/StageController.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['utilisateur'])) {
    header('Location: /login');
    exit();
}

$utilisateur = $_SESSION['utilisateur'];
$role = $utilisateur['role'];
$userId = $utilisateur['id'];


$stageController = new StageController($pdo);

$stageController->afficherStages($role, $userId);

?>
