<div class="container mx-auto px-6 md:px-12 py-12 bg-white shadow-md rounded-lg mt-12">
    <h1 class="text-4xl font-bold text-indigo-900 mb-8">Détails du Stage</h1>

    <div class="bg-gray-50 p-6 rounded-lg shadow hover:shadow-lg transition transform hover:scale-105">
        <p class="text-gray-800 text-lg mb-4">
            <strong>Étudiant :</strong> <?= htmlspecialchars($stage['etudiant_nom']) ?> (<?= htmlspecialchars($stage['etudiant_email']) ?>)
        </p>
        <p class="text-gray-800 text-lg mb-4">
            <strong>Mission :</strong> <?= htmlspecialchars($stage['mission']) ?>
        </p>
        <p class="text-gray-800 text-lg mb-4">
            <strong>Date de début :</strong> <?= htmlspecialchars($stage['date_debut']) ?>
        </p>
        <p class="text-gray-800 text-lg mb-4">
            <strong>Date de fin :</strong> <?= htmlspecialchars($stage['date_fin']) ?>
        </p>
        <?php if (!empty($stage['date_soutenance'])): ?>
            <p class="text-gray-800 text-lg mb-4">
                <strong>Date de soutenance :</strong> <?= htmlspecialchars($stage['date_soutenance']) ?>
            </p>
            <p class="text-gray-800 text-lg mb-4">
                <strong>Salle de soutenance :</strong> <?= htmlspecialchars($stage['salle_soutenance']) ?>
            </p>
        <?php endif; ?>
    </div>

    <div class="mt-8">
        <a href="/stage" class="bg-indigo-900 text-white px-6 py-3 rounded-lg shadow hover:bg-indigo-700 transition">
            Retour à la liste des stages
        </a>
    </div>
</div>