<div class="container mx-auto py-8 px-4">
    <!-- Titre + Bouton d'ajout alignés sur la même ligne -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Liste des Stages</h2>
        <button 
            class="inline-flex items-center px-6 py-2 text-white bg-indigo-600 
                   rounded-lg hover:bg-indigo-700 transition-colors duration-200 
                   focus:outline-none focus:ring focus:ring-indigo-300"
        >
            <!-- Icône SVG (optionnel) -->
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Ajouter un Stage
        </button>
    </div>

    <?php if (empty($stages)) : ?>
        <p class="text-center text-xl text-gray-600">Aucun stage disponible.</p>
    <?php else : ?>
        <!-- Carte blanche pour le tableau -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Mission
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date Début
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date Fin
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Étudiant
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tuteur Pédagogique
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tuteur Entreprise
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach ($stages as $stage) : ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?= htmlspecialchars($stage['id_stage']) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?= htmlspecialchars($stage['mission']) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?= htmlspecialchars($stage['date_debut']) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?= htmlspecialchars($stage['date_fin']) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?= htmlspecialchars($stage['etudiant'] ?? 'Non attribué') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?= htmlspecialchars($stage['tuteur_pedagogique'] ?? 'Non attribué') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?= htmlspecialchars($stage['tuteur_entreprise'] ?? 'Non attribué') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <!-- Boutons d'action -->
                                <div class="inline-flex g2">
                                    <button class="p-4 text-white bg-blue-500 hover:bg-blue-600 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400">
                                        Détails
                                    </button>
                                    <button class="p-4 text-white bg-red-500 hover:bg-red-600 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-400">
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
</div>
