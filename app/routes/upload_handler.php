<?php


if (isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $stageId = isset($_POST['stage_id']) ? $_POST['stage_id'] : null;


    // Définir les types de fichiers autorisés et la taille maximale
    $allowedTypes = ['application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
    $maxSize = 2 * 1024 * 1024; // 2 Mo
    

    if (!in_array($file['type'], $allowedTypes)) {
        $_SESSION['upload_message'] = "Type de fichier non autorisé. Veuillez déposer un PDF ou un DOCX.";
        header("Location: /upload?id_stage=" . $stageId);
        exit();
    }

    if ($file['size'] > $maxSize) {
        $_SESSION['upload_message'] = "Le fichier est trop volumineux. Limite : 2 Mo.";
        header("Location: /upload?id_stage=" . $stageId);
        exit();
    }

    // Chemin du dossier d'upload
    $uploadDir = __DIR__ . '/../uploads/stage_' . $stageId . '/';
    var_dump("Chemin du dossier :", $uploadDir);

    // Création du dossier si nécessaire
    if (!file_exists($uploadDir)) {
        if (mkdir($uploadDir, 0777, true)) {
            var_dump("Dossier créé !");
        } else {
            var_dump("Erreur : impossible de créer le dossier.");
        }
    }

    // Déplacement du fichier
    $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newFileName = 'stage_' . $stageId . '_' . time() . '.' . $fileExtension;

    $filePath = $uploadDir . $newFileName;
    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        var_dump("Fichier déposé avec succès :", $filePath);
    } else {
        var_dump("Erreur lors du déplacement du fichier.");
    }

    exit();
} else {
    var_dump("Aucun fichier détecté.");
    exit();
}
