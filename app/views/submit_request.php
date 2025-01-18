<?php
// Vérification du rôle (étudiant uniquement)
require_once __DIR__ . '/../utils/auth_helpers.php';
requireRole('Etudiant');
?>

<div class="container mx-auto py-8 px-4">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Faire une demande de stage</h2>

    <form action="/submit_stage_request" method="POST" class="bg-white shadow-md rounded-lg p-6 space-y-6">
        <div>
            <label for="mission" class="block text-gray-700 font-bold mb-2">Mission :</label>
            <textarea id="mission" name="mission" rows="4" required
                      class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400"></textarea>
        </div>

        <div>
            <label for="date_debut" class="block text-gray-700 font-bold mb-2">Date de début :</label>
            <input type="date" id="date_debut" name="date_debut" required
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>

        <div>
            <label for="date_fin" class="block text-gray-700 font-bold mb-2">Date de fin :</label>
            <input type="date" id="date_fin" name="date_fin" required
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>

        <div>
            <button type="submit"
                    class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                Soumettre la demande
            </button>
        </div>
    </form>
</div>
