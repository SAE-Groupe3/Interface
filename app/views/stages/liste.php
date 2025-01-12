<div class="container mx-auto px-6 md:px-12 py-12 bg-white shadow-md rounded-lg mt-12">
    <h1 class="text-4xl font-bold text-indigo-900 mb-8">Mes Stages</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($stages as $stage): ?>
            <div class="bg-gray-100 p-6 rounded-lg shadow hover:shadow-lg transition">
                <h2 class="text-2xl font-bold text-indigo-900 mb-4"><?= htmlspecialchars($stage['mission']) ?></h2>
                <p class="text-gray-600 mb-2"><strong>Date de début :</strong> <?= htmlspecialchars($stage['date_debut']) ?></p>
                <p class="text-gray-600 mb-4"><strong>Date de fin :</strong> <?= htmlspecialchars($stage['date_fin']) ?></p>

                
                    <div class="flex space-x-4">
                    <a href="/stage/details?id=<?= $stage['id_stage'] ?>" class="bg-indigo-900 text-white px-4 py-2 rounded-lg shadow hover:bg-indigo-700">Voir les détails</a>
                    <?php if ($role === 'admin' || $role === 'tuteur'): ?>
                        <a href="/stage/edit?id=<?= $stage['id_stage'] ?>" class="bg-indigo-900 text-white px-4 py-2 rounded-lg shadow hover:bg-indigo-700">
                            Modifier
                        </a>
                        <a href="/stage/delete?id=<?= $stage['id_stage'] ?>" class="bg-red-600 text-white px-4 py-2 rounded-lg shadow hover:bg-red-500">
                            Supprimer
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>