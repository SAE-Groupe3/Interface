<div class="container mx-auto py-8 px-4">
    <h1 class="text-3xl font-bold text-indigo-900 mb-6">Gérer les Stages</h1>

    <?php if (empty($stages)) : ?>
        <p class="text-gray-600">Aucun stage disponible.</p>
    <?php else : ?>
        <div class="space-y-4">
            <?php foreach ($stages as $stage) : ?>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <p><strong>ID :</strong> <?= htmlspecialchars($stage['id_stage']) ?></p>
                    <p><strong>Mission :</strong> <?= htmlspecialchars($stage['mission']) ?></p>
                    <p><strong>Date Début :</strong> <?= htmlspecialchars($stage['date_debut']) ?></p>
                    <p><strong>Date Fin :</strong> <?= htmlspecialchars($stage['date_fin']) ?></p>
                    <div class="mt-4 flex justify-end space-x-4">
                        <a href="/stage/details?id=<?= urlencode($stage['id_stage']) ?>" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Détails</a>
                        <a href="/delete_stage?id=<?= urlencode($stage['id_stage']) ?>" 
                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600"
                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce stage ?');">
                        Supprimer
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['success'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: "<?= htmlspecialchars($_SESSION['success']); ?>",
                confirmButtonColor: '#4caf50',
            });
        });
    </script>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: "<?= htmlspecialchars($_SESSION['error']); ?>",
                confirmButtonColor: '#f44336',
            });
        });
    </script>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

</div>
