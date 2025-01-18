<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur'])) {
    echo "Utilisateur non connecté.";
    exit;
}

// Récupérer les informations de l'utilisateur
$utilisateur = $_SESSION['utilisateur'];
?>

<div class="container mx-auto px-6 md:px-12 py-12 bg-white shadow-md rounded-lg mt-12">
    <h1 class="text-4xl font-bold text-indigo-900 mb-4">Bienvenue dans votre tableau de bord !</h1>
    <p class="text-gray-700 text-lg mb-6">
    Vous êtes connecté en tant que 
    <strong><?= htmlspecialchars($utilisateur['email'] ?? 'Utilisateur') ?></strong>
    (<em><?= htmlspecialchars($utilisateur['role'] ?? 'Non défini') ?></em>).
</p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Boutons du dashboard -->
        <a href="/stage" class="bg-indigo-900 text-white px-6 py-4 rounded-lg shadow hover:bg-indigo-700 text-center">
            📁 Voir les stages
        </a>

        <?php if ($utilisateur['role'] === 'Administrateur'): ?>
            <a href="/manage_requests" class="bg-indigo-900 text-white px-6 py-4 rounded-lg shadow hover:bg-indigo-700 text-center">
                👥 Gérer les demandes de stages
            </a>
        <?php endif; ?>

        <a href="/logout" class="bg-indigo-900 text-white px-6 py-4 rounded-lg shadow hover:bg-indigo-700 text-center">
            🔒 Déconnexion
        </a>
    </div>

    <!-- Section des statistiques -->
    <div class="mt-12 bg-gray-100 p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-indigo-900 mb-4">Statistiques</h2>
        <ul class="space-y-2 text-gray-700">
            <li>📋 Nombre de stages : <?= rand(5, 50) ?></li>
            <li>👥 Nombre d'utilisateurs : <?= rand(10, 100) ?></li>
            <li>🏢 Nombre d'entreprises partenaires : <?= rand(3, 20) ?></li>
        </ul>
    </div>
</div>