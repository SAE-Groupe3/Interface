<?php
// public/index.php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once "../config/database.php";
require_once "../routes/utilisateurs.php";
require_once "../routes/stages.php";

// Connexion à la base de données
$database = new Database();
$db = $database->getConnection();

// Exemple de réponse
echo json_encode(["message" => "API Gestion des Stages opérationnelle"]);
?>
