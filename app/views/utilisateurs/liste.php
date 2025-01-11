<h2>Liste des stages</h2>
<?php foreach ($stages as $stage) : ?>
    <p><strong>Stage :</strong> <?= $stage['mission'] ?> - Étudiant : <?= $stage['etudiant_nom'] ?></p>
<?php endforeach; ?>
