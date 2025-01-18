<?php
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur'])) {
    header("Location: /login");
    exit();
}
?>

<div class="container mx-auto py-12 px-6" data-aos="fade-up">
    <!-- Titre principal avec une icône -->
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-4xl font-bold text-indigo-900 flex items-center">
            <svg class="w-8 h-8 mr-3 text-indigo-900" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h11M9 21V3m0 18l7-7-7-7"></path>
            </svg>
            Liste des Stages
        </h2>
        <?php if ($role === 'Etudiant') : ?>
            <a href="/submit_request" 
               class="px-6 py-3 bg-indigo-900 text-white rounded-lg hover:bg-indigo-800 transition">
                Faire une demande de stage
            </a>
        <?php endif; ?>
        <?php if ($role === 'Administrateur') : ?>
            <a href="/manage_requests" 
               class="px-6 py-3 bg-indigo-900 text-white rounded-lg hover:bg-indigo-800 transition">
                Gérer les demandes de stage
            </a>
        <?php endif; ?>
    </div>

    <!-- Message si aucun stage n'est disponible -->
    <?php if (empty($stages)) : ?>
        <p class="text-center text-2xl text-gray-500">Aucun stage disponible.</p>
    <?php else : ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($stages as $stage) : ?>
                <div class="bg-white shadow-lg rounded-lg p-6 transform hover:scale-105 transition duration-300" data-aos="fade-up" style="min-height: 300px; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div class="mb-4">
                            <h3 class="text-2xl font-semibold text-indigo-900 mb-2">
                                <?= htmlspecialchars($stage['mission']) ?>
                            </h3>
                            <p class="text-gray-600 text-sm">
                                ID : <?= htmlspecialchars($stage['id_stage']) ?>
                            </p>
                        </div>

                        <p class="text-gray-800 mb-2">
                            <strong>Date Début :</strong> <?= htmlspecialchars($stage['date_debut']) ?>
                        </p>
                        <p class="text-gray-800 mb-2">
                            <strong>Date Fin :</strong> <?= htmlspecialchars($stage['date_fin']) ?>
                        </p>
                        <p class="text-gray-800 mb-2">
                            <strong>Étudiant :</strong> <?= htmlspecialchars($stage['etudiant'] ?? 'Non attribué') ?>
                        </p>
                        <p class="text-gray-800 mb-2">
                            <strong>Tuteur Pédagogique :</strong> <?= htmlspecialchars($stage['tuteur_pedagogique'] ?? 'Non attribué') ?>
                        </p>
                        <p class="text-gray-800 mb-4">
                            <strong>Tuteur Entreprise :</strong> <?= htmlspecialchars(trim($stage['tuteur_entreprise']) !== '' ? $stage['tuteur_entreprise'] : 'Non attribué') ?>
                        </p>
                    </div>

                    <div class="flex justify-start items-center mt-4">
                        <a href="/stage/details?id=<?= urlencode($stage['id_stage']) ?>"
                           class="inline-flex items-center px-4 py-2 bg-indigo-900 text-white rounded-lg hover:bg-indigo-800 transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m6 0H9m0 0h6"></path>
                            </svg>
                            Détails
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Intégration AOS Animation -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        AOS.init({
            duration: 1000,
            once: true,
        });
    });
</script>
