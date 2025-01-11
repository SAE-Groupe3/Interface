<?php
require_once '../config/db.php';

// Route pour afficher les utilisateurs
$query = $pdo->query("SELECT * FROM Utilisateur");

$utilisateurs = $query->fetchAll(PDO::FETCH_ASSOC);

echo "<h2>Liste des utilisateurs</h2>";
foreach ($utilisateurs as $utilisateur) {
    echo "<p>" . $utilisateur['nom'] . " " . $utilisateur['prenom'] . " (" . $utilisateur['email'] . ")</p>";
}
