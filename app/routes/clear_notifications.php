<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $userId = $input['userId'] ?? null;

    if ($userId && isset($_SESSION['notifications'][$userId])) {
        unset($_SESSION['notifications'][$userId]);
        echo json_encode(['success' => true]);
        exit;
    }
}

echo json_encode(['success' => false, 'message' => 'Aucune notification à supprimer']);
exit;
