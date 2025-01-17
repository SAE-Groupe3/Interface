<?php
// Récupérer les informations du stage et des enseignants
?>

<h1 class="text-4xl font-bold text-indigo-900 mb-8">Modifier le Stage</h1>

<form action="/stage/edit?id=<?= htmlspecialchars($stage['id_stage']) ?>" method="POST" class="space-y-6 bg-gray-100 p-6 rounded-lg shadow">
    <input type="hidden" name="id_stage" value="<?= htmlspecialchars($stage['id_stage']) ?>">

    <div>
        <label for="mission" class="block text-gray-700 font-bold mb-2">Mission :</label>
        <input type="text" id="mission" name="mission" value="<?= htmlspecialchars($stage['mission']) ?>" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
    </div>

    <div>
        <label for="id_tuteur_pedagogique" class="block text-gray-700 font-bold mb-2">Tuteur Pédagogique :</label>
        <select name="id_tuteur_pedagogique" id="id_tuteur_pedagogique" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
            <option value="">Sélectionner un tuteur</option>

            <?php foreach ($enseignants as $enseignant): ?>
                <option value="<?= htmlspecialchars($enseignant['id']) ?>" <?= ($stage['id_tuteur_pedagogique'] == $enseignant['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($enseignant['nom'] . ' ' . $enseignant['prenom']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg shadow hover:bg-indigo-500">
        Modifier le tuteur
    </button>
</form>

<!-- Retour à la liste des stages -->
<div class="mt-8 flex">
    <a href="/stage" class="bg-indigo-900 text-white px-6 py-3 rounded-lg shadow hover:bg-indigo-700 transition">
        Retour à la liste des stages
    </a>
</div>
