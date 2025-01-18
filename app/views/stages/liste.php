<?php
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur'])) {
    header("Location: /login");
    exit();
}

// Récupérer le rôle de l'utilisateur
$role = $_SESSION['utilisateur']['role'];
?>

<div class="container mx-auto py-8 px-4">
    <!-- Titre principal -->
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Liste des Stages</h2>

    <?php if (empty($stages)) : ?>
        <p class="text-center text-xl text-gray-600">Aucun stage disponible.</p>
    <?php else : ?>
        <div class="space-y-6">
            <?php foreach ($stages as $stage) : ?>
                <div class="bg-white shadow-md rounded-lg p-6">
                    <p class="text-gray-800"><strong>ID :</strong> <?= htmlspecialchars($stage['id_stage']) ?></p>
                    <p class="text-gray-800"><strong>Mission :</strong> <?= htmlspecialchars($stage['mission']) ?></p>
                    <p class="text-gray-800"><strong>Date Début :</strong> <?= htmlspecialchars($stage['date_debut']) ?></p>
                    <p class="text-gray-800"><strong>Date Fin :</strong> <?= htmlspecialchars($stage['date_fin']) ?></p>
                    <p class="text-gray-800"><strong>Étudiant :</strong> <?= htmlspecialchars($stage['etudiant'] ?? 'Non attribué') ?></p>
                    <p class="text-gray-800"><strong>Tuteur Pédagogique :</strong> <?= htmlspecialchars($stage['tuteur_pedagogique'] ?? 'Non attribué') ?></p>
                    <p class="text-gray-800"><strong>Tuteur Entreprise :</strong> <?= htmlspecialchars($stage['tuteur_entreprise'] ?? 'Non attribué') ?></p>
                    <div class="flex space-x-4 mt-4">
                        <a href="/stage/details?id=<?= urlencode($stage['id_stage']) ?>"
                           class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                            Détails
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Bouton pour faire une demande (visible uniquement pour les étudiants) -->
    <div class="mt-8 text-center space-y-4">
        <?php if ($role === 'Etudiant') : ?>
            <a href="/submit_request" 
               class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                Faire une demande de stage
            </a>
        <?php endif; ?>

        <?php if ($role === 'Administrateur') : ?>
            <a href="/manage_requests" 
               class="px-6 py-3 bg-green-600 text-black rounded-lg hover:bg-green-700 transition">
                Gérer les demandes de stage
            </a>
        <?php endif; ?>
    </div>
</div>
