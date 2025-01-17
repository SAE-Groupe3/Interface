<div class="container mx-auto my-8" data-aos="fade-up">
    <!-- Titre avec une icône SVG -->
    <h1 class="flex items-center justify-center text-3xl font-bold text-center text-gray-800 mb-6 animate__animated animate__fadeInDown">
        <!-- Icône SVG (remplacez éventuellement la source par la vôtre) -->
        <svg class="w-8 h-8 mr-2 text-indigo-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 2.25c.916 0 1.75.834 1.75 1.75v1.75h2.5V4a1.75 1.75 0 1 1 3.5 0v1.75h.75a2.25 2.25 0 0 1 2.25 2.25v1.105c0 3.53-2.858 6.418-6.387 6.393C9.359 15.468 6.5 12.579 6.5 9.049V7.25a2.25 2.25 0 0 1 2.25-2.25h.75V4c0-.916.834-1.75 1.75-1.75z"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 9.75h10.5M10 13.75h4"/>
        </svg>
        Liste des Stages
    </h1>
    
    <?php if (empty($stages)) : ?>
        <div class="text-center text-gray-700">
            <p class="text-xl">Aucun stage disponible.</p>
        </div>
    <?php else : ?>
        <!-- Table avec animation AOS -->
        <div class="overflow-x-auto bg-white shadow-md rounded-lg animate__animated animate__fadeIn" data-aos="fade-up">
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
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-4 py-2 border-b"><?= htmlspecialchars($stage['id_stage']) ?></td>
                            <td class="px-4 py-2 border-b"><?= htmlspecialchars($stage['mission']) ?></td>
                            <td class="px-4 py-2 border-b"><?= htmlspecialchars($stage['date_debut']) ?></td>
                            <td class="px-4 py-2 border-b"><?= htmlspecialchars($stage['date_fin']) ?></td>
                            <td class="px-4 py-2 border-b"><?= htmlspecialchars($stage['etudiant'] ?? 'Non attribué') ?></td>
                            <td class="px-4 py-2 border-b"><?= htmlspecialchars($stage['tuteur_pedagogique'] ?? 'Non attribué') ?></td>
                            <td class="px-4 py-2 border-b"><?= htmlspecialchars($stage['tuteur_entreprise'] ?? 'Non attribué') ?></td>
                            <td class="px-4 py-2 border-b text-center">
                                <div class="flex justify-center gap-2">
                                    <button class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300 transition-colors duration-200">
                                        Détails
                                    </button>
                                    <button class="px-4 py-2 text-sm font-semibold text-white bg-green-600 rounded hover:bg-green-700 focus:outline-none focus:ring focus:ring-green-300 transition-colors duration-200">
                                        Modifier
                                    </button>
                                    <button class="px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded hover:bg-red-700 focus:outline-none focus:ring focus:ring-red-300 transition-colors duration-200">
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

    <!-- Bouton Ajouter avec icône SVG -->
    <div class="text-center mt-6" data-aos="fade-in">
        <button class="inline-flex items-center px-6 py-3 text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition-colors duration-200 focus:outline-none focus:ring focus:ring-indigo-300">
            <!-- Icône SVG (remplacez la source si besoin) -->
            <svg class="w-5 h-5 mr-2 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Ajouter un Stage
        </button>
    </div>
</div>
