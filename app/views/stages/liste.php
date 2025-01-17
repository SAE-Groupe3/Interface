<div class="container mx-auto my-8">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Liste des Stages</h1>
        
        <?php if (empty($stages)) : ?>
            <div class="text-center text-gray-700">
                <p class="text-xl">Aucun stage disponible.</p>
            </div>
        <?php else : ?>
            <div class="overflow-x-auto bg-white shadow-md rounded-lg">
                <table class="w-full border-collapse border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-gray-700 border-b">ID</th>
                            <th class="px-4 py-2 text-left text-gray-700 border-b">Mission</th>
                            <th class="px-4 py-2 text-left text-gray-700 border-b">Date Début</th>
                            <th class="px-4 py-2 text-left text-gray-700 border-b">Date Fin</th>
                            <th class="px-4 py-2 text-left text-gray-700 border-b">Étudiant</th>
                            <th class="px-4 py-2 text-left text-gray-700 border-b">Tuteur Pédagogique</th>
                            <th class="px-4 py-2 text-left text-gray-700 border-b">Tuteur Entreprise</th>
                            <th class="px-4 py-2 text-center text-gray-700 border-b">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stages as $stage) : ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border-b"><?= htmlspecialchars($stage['id_stage']) ?></td>
                                <td class="px-4 py-2 border-b"><?= htmlspecialchars($stage['mission']) ?></td>
                                <td class="px-4 py-2 border-b"><?= htmlspecialchars($stage['date_debut']) ?></td>
                                <td class="px-4 py-2 border-b"><?= htmlspecialchars($stage['date_fin']) ?></td>
                                <td class="px-4 py-2 border-b"><?= htmlspecialchars($stage['etudiant'] ?? 'Non attribué') ?></td>
                                <td class="px-4 py-2 border-b"><?= htmlspecialchars($stage['tuteur_pedagogique'] ?? 'Non attribué') ?></td>
                                <td class="px-4 py-2 border-b"><?= htmlspecialchars($stage['tuteur_entreprise'] ?? 'Non attribué') ?></td>
                                <td class="px-4 py-2 border-b text-center">
                                    <!-- Actions -->
                                    <div class="flex justify-center gap-2">
                                        <button class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded hover:bg-blue-700">
                                            Détails
                                        </button>
                                        <button class="px-4 py-2 text-sm font-semibold text-white bg-green-600 rounded hover:bg-green-700">
                                            Modifier
                                        </button>
                                        <button class="px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded hover:bg-red-700">
                                            Supprimer
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <div class="text-center mt-6">
            <button class="px-6 py-3 text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                Ajouter un Stage
            </button>
        </div>
    </div>