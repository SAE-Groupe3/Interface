<?php
require_once '../config/db.php';

// Route pour afficher les stages
$query = $pdo->query("
    SELECT Stage.Id_Stage, Utilisateur.nom AS etudiant_nom, Stage.mission 
    FROM Stage
    JOIN Utilisateur ON Stage.id_etudiant = Utilisateur.Id
");

$stages = $query->fetchAll(PDO::FETCH_ASSOC);

echo "<h2>Liste des stages</h2>";
foreach ($stages as $stage) {
    echo "<p><strong>Stage :</strong> " . $stage['mission'] . " - Étudiant : " . $stage['etudiant_nom'] . "</p>";
}
