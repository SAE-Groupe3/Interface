<?php
require_once __DIR__ . '/../utils/auth_helpers.php';
requireRole('Administrateur'); // Vérifie que seul l'administrateur peut accéder

// Récupération des demandes de stage
require_once '../models/Stage.php';
$stageModel = new Stage($pdo);
$demandes = $stageModel->getStageRequests(); // Méthode pour récupérer les demandes

?>

<div class="container mx-auto py-8 px-4">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Demandes de Stage</h2>

    <?php if (empty($demandes)) : ?>
    <p class="text-center text-xl text-gray-600">Aucune demande de stage en attente.</p>
<?php else : ?>
    <div class="space-y-6">
        <?php foreach ($demandes as $demande) : ?>
            <div class="bg-white shadow-md rounded-lg p-6 border-l-4 border-indigo-500">
                <p class="text-gray-800"><strong>Étudiant :</strong> <?= htmlspecialchars($demande['etudiant']) ?></p>
                <p class="text-gray-800"><strong>Mission :</strong> <?= htmlspecialchars($demande['mission']) ?></p>
                <p class="text-gray-800"><strong>Dates :</strong> <?= htmlspecialchars($demande['date_debut']) ?> - <?= htmlspecialchars($demande['date_fin']) ?></p>
                <div class="flex space-x-4 mt-4">
                    <?php if (isset($demande['id_action'])) : ?>
                        <!-- Bouton Valider -->
                        <a href="/validate_request?id=<?= urlencode($demande['id_action']) ?>&action=validate"
                           class="px-4 py-2 bg-green-500 text-white rounded-lg flex items-center gap-2 hover:bg-green-600">
                            ✅ Valider
                        </a>
                        <!-- Bouton Rejeter -->
                        <a href="/validate_request?id=<?= urlencode($demande['id_action']) ?>&action=reject"
                           class="px-4 py-2 bg-red-500 text-white rounded-lg flex items-center gap-2 hover:bg-red-600">
                            ❌ Rejeter
                        </a>
                    <?php else : ?>
                        <p class="text-red-500">Action non définie.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>


</div>

