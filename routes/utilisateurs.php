<?php
// routes/utilisateurs.php

require_once "../config/database.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Récupérer tous les utilisateurs
    $query = "SELECT * FROM Utilisateur";
    $stmt = $db->prepare($query);
    $stmt->execute();

    $utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($utilisateurs);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ajouter un nouvel utilisateur
    $data = json_decode(file_get_contents("php://input"), true);

    $query = "INSERT INTO Utilisateur (nom, prenom, email, telephone, login, motdepasse) VALUES (:nom, :prenom, :email, :telephone, :login, :motdepasse)";
    $stmt = $db->prepare($query);

    $stmt->bindParam(":nom", $data['nom']);
    $stmt->bindParam(":prenom", $data['prenom']);
    $stmt->bindParam(":email", $data['email']);
    $stmt->bindParam(":telephone", $data['telephone']);
    $stmt->bindParam(":login", $data['login']);
    $stmt->bindParam(":motdepasse", $data['motdepasse']);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Utilisateur ajouté avec succès"]);
    } else {
        echo json_encode(["message" => "Erreur lors de l'ajout de l'utilisateur"]);
    }
}
?>
