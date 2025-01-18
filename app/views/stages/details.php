<?php
// Calcul du nombre de jours restants jusqu'à la date de fin du stage
$dateActuelle = new DateTime();
$dateFinStage = new DateTime($stage['date_fin']);
$interval = $dateActuelle->diff($dateFinStage);
$joursRestants = $interval->days;
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialisation du compte à rebours
        startCountdown('<?= $stage['date_fin'] ?>');

        // Animation du path SVG
        anime({
        targets: '#animated-path',
        strokeDasharray: [0, 100], // Dessine progressivement
        strokeDashoffset: [100, 0], // Décale progressivement
        easing: 'easeInOutQuad', // Animation douce
        duration: 1500, // Durée de l'animation
        loop: true // Animation en boucle
    });
    });
</script>

<!-- Conteneur principal -->
<div class="container mx-auto py-8 px-4" data-aos="fade-up">


    <!-- Titre principal avec animation SVG -->
    <div class="flex items-center justify-start mb-8">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-indigo-900 mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path id="animated-path" stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m2 0a2 2 0 100-4h-1.38a1 1 0 00-.76.36l-2.83 3.17a1 1 0 01-1.5 0l-2.83-3.17a1 1 0 00-.76-.36H7a2 2 0 100 4h2m4 0v6m-4 0h4" />
        </svg>
        <h1 class="text-4xl font-bold font-bold text-indigo-900">Détails du Stage</h1>
    </div>

    <!-- Carte contenant les informations principales du stage -->
    <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition transform hover:scale-[1.02] animate__animated animate__fadeIn" data-aos="fade-up">
        <!-- Étudiant -->
        <p class="text-gray-800 text-base md:text-lg mb-4">
            <strong>Étudiant : </strong>
            <?= htmlspecialchars($stage['etudiant_nom']) ?>
            (<?= htmlspecialchars($stage['etudiant_email']) ?>)
        </p>

        <!-- Tuteur pédagogique -->
        <p class="text-gray-800 text-base md:text-lg mb-4">
            <strong>Tuteur pédagogique : </strong>
            <?= htmlspecialchars($stage['tuteur_nom'] . ' ' . $stage['tuteur_prenom']) ?> 
            (<?= htmlspecialchars($stage['tuteur_email'] ?? 'Non assigné') ?>)
        </p>

        <!-- Tuteur entreprise -->
        <p class="text-gray-800 text-base md:text-lg mb-4">
            <strong>Tuteur Entreprise : </strong>
            <?= isset($stage['tuteur_entreprise_nom']) 
                ? htmlspecialchars($stage['tuteur_entreprise_nom'] . ' ' . $stage['tuteur_entreprise_prenom']) 
                : 'Non attribué' ?>
            (<?= htmlspecialchars($stage['tuteur_entreprise_email'] ?? 'Non assigné') ?>)
            
        </p>

        <!-- Mission -->
        <p class="text-gray-800 text-base md:text-lg mb-4">
            <strong>Mission : </strong>
            <?= htmlspecialchars($stage['mission']) ?>
        </p>

        <!-- Dates de début et de fin -->
        <p class="text-gray-800 text-base md:text-lg mb-4">
            <strong>Date de début : </strong>
            <?= htmlspecialchars($stage['date_debut']) ?>
        </p>
        <p class="text-gray-800 text-base md:text-lg mb-4">
            <strong>Date de fin : </strong>
            <?= htmlspecialchars($stage['date_fin']) ?>
        </p>

        <!-- Temps restant -->
        <p class="text-gray-800 text-base md:text-lg mb-4">
            <strong>Temps restant avant la fin du stage : </strong>
            <span id="countdown" class="font-semibold">Calcul en cours...</span>
        </p>

        <!-- Date et salle de soutenance (si présentes) -->
        <?php if (!empty($stage['date_soutenance'])) : ?>
            <p class="text-gray-800 text-base md:text-lg mb-4">
                <strong>Date de soutenance :</strong>
                <?= htmlspecialchars($stage['date_soutenance']) ?>
            </p>
            <p class="text-gray-800 text-base md:text-lg mb-4">
                <strong>Salle de soutenance :</strong>
                <?= htmlspecialchars($stage['salle_soutenance']) ?>
            </p>
        <?php endif; ?>

        <!-- Liste des fichiers déposés -->
        <?php
            $stageId = $stage['id_stage'];
            $uploadDir = __DIR__ . "/../../uploads/stage_$stageId/";

            echo '<div class="mt-6">';
            if (is_dir($uploadDir)) {
                $files = array_diff(scandir($uploadDir), ['.', '..']);

                echo "<h2 class='text-xl font-semibold text-indigo-800 mb-4'>Fichiers déposés :</h2>";
                if (count($files) > 0) {
                    echo "<ul class='space-y-2'>";
                    foreach ($files as $file) {
                        $filePath = "/uploads/stage_$stageId/" . htmlspecialchars($file);
                        echo "<li><a href='$filePath' target='_blank' class='text-indigo-600 hover:underline'>$file</a></li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p class='text-gray-600'>Aucun fichier déposé pour ce stage.</p>";
                }
            } else {
                echo "<p class='text-gray-600'>Aucun fichier déposé pour ce stage.</p>";
            }
            echo '</div>';
        ?>
    </div>

    <!-- Soutenance -->
    <div class="mt-12">
        <h2 class="text-2xl font-bold text-indigo-900 mb-4">Soutenance :</h2>

        <?php if ($_SESSION['utilisateur']['role'] === 'tuteur') : ?>
            <!-- Formulaire pour les tuteurs -->
            <form action="/routes/update_soutenance.php" method="POST" class="space-y-6 bg-gray-50 p-6 rounded-lg shadow">
                <input type="hidden" name="id_stage" value="<?= htmlspecialchars($stage['id_stage']) ?>">

                <div>
                    <label for="date_soutenance" class="block text-gray-700 font-bold mb-2">Date de la soutenance :</label>
                    <input type="date"
                           name="date_soutenance"
                           id="date_soutenance"
                           value="<?= htmlspecialchars($stage['date_soutenance'] ?? '') ?>"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
                </div>

                <div>
                    <label for="salle_soutenance" class="block text-gray-700 font-bold mb-2">Salle de soutenance :</label>
                    <input type="text"
                           name="salle_soutenance"
                           id="salle_soutenance"
                           value="<?= htmlspecialchars($stage['salle_soutenance'] ?? '') ?>"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg shadow hover:bg-indigo-500">
                        Sauvegarder
                    </button>
                    <?php if (!empty($stage['date_soutenance'])): ?>
                        <a href="/routes/delete_soutenance.php?id_stage=<?= htmlspecialchars($stage['id_stage']) ?>"
                           class="bg-red-600 text-white px-6 py-2 rounded-lg shadow hover:bg-red-500">
                            Supprimer
                        </a>
                    <?php endif; ?>
                </div>
            </form>

        <?php else : ?>
            <!-- Affichage pour les étudiants -->
            <?php if (!empty($stage['date_soutenance'])) : ?>
                <p class="text-gray-800 text-base md:text-lg mb-4">
                    <strong>Date de soutenance :</strong>
                    <?= htmlspecialchars($stage['date_soutenance']) ?>
                </p>
                <p class="text-gray-800 text-base md:text-lg mb-4">
                    <strong>Salle de soutenance :</strong>
                    <?= htmlspecialchars($stage['salle_soutenance']) ?>
                </p>
            <?php else : ?>
                <p class="text-gray-800 text-base md:text-lg">
                    Pas de soutenance pour l'instant.
                </p>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <!-- Assigner / modifier Tuteur Pédagogique si admin ou tuteur -->
    <?php if ($_SESSION['utilisateur']['role'] === 'Administrateur' ): ?>
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-indigo-900 mb-4">Assigner ou Modifier le Tuteur Pédagogique :</h2>

            <form action="/routes/assign_tuteur" method="POST" class="space-y-6 bg-gray-50 p-6 rounded-lg shadow">
                <input type="hidden" name="id_stage" value="<?= htmlspecialchars($stage['id_stage']) ?>">

                <div>
                    <label for="id_tuteur_pedagogique" class="block text-gray-700 font-bold mb-2">
                        Tuteur Pédagogique :
                    </label>
                    <select name="id_tuteur_pedagogique"
                            id="id_tuteur_pedagogique"
                            required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
                        <option value="">Sélectionner un tuteur</option>

                        <?php foreach ($enseignants as $enseignant): ?>
                            <option value="<?= htmlspecialchars($enseignant['id']) ?>"
                                <?= (isset($stage['id_tuteur_pedagogique']) && $enseignant['id'] == $stage['id_tuteur_pedagogique']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($enseignant['nom'] . ' ' . $enseignant['prenom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit"
                        class="bg-indigo-900 text-white px-6 py-2 rounded-lg shadow hover:bg-indigo-500">
                    <?= isset($stage['id_tuteur_pedagogique']) ? 'Modifier le tuteur' : 'Assigner un tuteur' ?>
                </button>
            </form>
        </div>
    <?php endif; ?>
    
    <?php if ($_SESSION['utilisateur']['role'] === 'Administrateur'): ?>
    <div class="mt-12">
        <h2 class="text-2xl font-bold text-indigo-900 mb-4">Assigner ou Modifier le Tuteur Entreprise :</h2>

        <form action="/routes/assign_tuteur_entreprise" method="POST" class="space-y-6 bg-gray-50 p-6 rounded-lg shadow">
            <input type="hidden" name="id_stage" value="<?= htmlspecialchars($stage['id_stage']) ?>">

            <div>
                <label for="id_tuteur_entreprise" class="block text-gray-700 font-bold mb-2">
                    Tuteur Entreprise :
                </label>
                <select name="id_tuteur_entreprise"
                        id="id_tuteur_entreprise"
                        required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    <option value="">Sélectionner un tuteur entreprise</option>

                    <?php foreach ($tuteursEntreprise as $tuteurEntreprise): ?>
                        <option value="<?= htmlspecialchars($tuteurEntreprise['id']) ?>"
                            <?= (isset($stage['id_tuteur_entreprise']) && $tuteurEntreprise['id'] == $stage['id_tuteur_entreprise']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($tuteurEntreprise['nom'] . ' ' . $tuteurEntreprise['prenom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit"
                    class="bg-indigo-600 text-white px-6 py-2 rounded-lg shadow hover:bg-indigo-500">
                <?= isset($stage['id_tuteur_entreprise']) ? 'Modifier le tuteur entreprise' : 'Assigner un tuteur entreprise' ?>
            </button>
        </form>
    </div>
<?php endif; ?>


    <!-- Liens de navigation (Retour et Déposer un fichier) -->
    <div class="mt-8 flex flex-wrap space-x-4">
        <a href="/stage"
           class="bg-indigo-900 text-white px-6 py-3 rounded-lg shadow hover:bg-indigo-700 transition">
            Retour à la liste des stages
        </a>
        <a href="/upload?id_stage=<?= htmlspecialchars($stage['id_stage']) ?>"
           class="bg-indigo-900 text-white px-6 py-3 rounded-lg shadow hover:bg-indigo-700 transition">
            Déposer un fichier
        </a>
    </div>
</div>

<!-- Script pour le compte à rebours -->
<script src="/assets/js/countdown.js" defer></script>
