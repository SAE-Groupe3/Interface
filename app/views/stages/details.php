<?php
// Calcul du nombre de jours restants jusqu'à la date de fin du stage
$dateActuelle = new DateTime();
$dateFinStage = new DateTime($stage['date_fin']);
$interval = $dateActuelle->diff($dateFinStage);
$joursRestants = $interval->days;
?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        startCountdown('<?= $stage['date_fin'] ?>');
    });
</script>

<div class="container mx-auto px-6 md:px-12 py-12 bg-white shadow-md rounded-lg mt-12" data-aos="fade-up">
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
        <p class="text-gray-800 text-lg mb-4">
            <strong>Temps restant avant la fin du stage :</strong>
            <span id="countdown">Calcul en cours...</span>
        </p>
        <?php if (!empty($stage['date_soutenance'])): ?>
            <p class="text-gray-800 text-lg mb-4">
                <strong>Date de soutenance :</strong> <?= htmlspecialchars($stage['date_soutenance']) ?>
            </p>
            <p class="text-gray-800 text-lg mb-4">
                <strong>Salle de soutenance :</strong> <?= htmlspecialchars($stage['salle_soutenance']) ?>
            </p>
        <?php endif; ?>

        <?php
            $stageId = $stage['id_stage'];
            $uploadDir = __DIR__ . "/../../uploads/stage_$stageId/";

            if (file_exists($uploadDir)) {
                echo "<h2 class='text-2xl font-bold text-indigo-900 mt-8 mb-4'>Fichiers déposés :</h2>";
                $files = array_diff(scandir($uploadDir), ['.', '..']);
                
                if (count($files) > 0) {
                    echo "<ul class='space-y-2'>";
                    foreach ($files as $file) {
                        echo "<li><a href='/uploads/stage_$stageId/$file' target='_blank' class='text-indigo-500 hover:underline'>$file</a></li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>Aucun fichier déposé pour ce stage.</p>";
                }
            } else {
                echo "<p>Aucun fichier déposé pour ce stage.</p>";
            }
            ?>
    </div>

    <div class="mt-8 flex">
        <a href="/stage" class="bg-indigo-900 text-white px-6 py-3 rounded-lg shadow hover:bg-indigo-700 transition">
            Retour à la liste des stages
        </a>
        <a href="/upload?id_stage=<?= htmlspecialchars($stage['id_stage']) ?>" class="bg-indigo-900 text-white px-6 py-3 rounded-lg shadow hover:bg-indigo-700 transition">
        Déposer un fichier
        </a>
    </div>
</div>

<script src="/assets/js/countdown.js" defer></script>