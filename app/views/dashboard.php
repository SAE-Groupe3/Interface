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
// Assurez-vous que $notifications est correctement défini
$notifications = $notifications ?? [];
?>

<script src="https://cdn.jsdelivr.net/npm/confetti-js"></script>
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

<script>
    document.addEventListener("DOMContentLoaded", function () {
        AOS.init({
            duration: 1000, // Durée de l'animation en ms
            once: true, // Animer seulement au premier scroll
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Récupération des notifications depuis PHP
        const notifications = <?= json_encode($notifications) ?>;

        // Affichage des notifications
        notifications.forEach(notification => {
            setTimeout(() => {
                // Effet de confettis
                confetti({
                    particleCount: 100,
                    spread: 70,
                    origin: { y: 0.6 }
                });

                // Notification avec Toastify
                Toastify({
                    text: notification.message,
                    duration: 5000,
                    close: true,
                    gravity: "top", // Affiche en haut
                    position: "right", // Positionne à droite
                    backgroundColor: notification.type === "success" ? "#4caf50" : "#f44336",
                    className: "rounded-lg shadow-lg",
                }).showToast();
            }, 500);
        });
    });
</script>




<div class="container mx-auto px-6 md:px-12 py-12 bg-white shadow-md rounded-lg mt-12" data-aos="fade-up">
    <h1 class="text-4xl font-bold text-indigo-900 mb-4" data-aos="zoom-in">Bienvenue dans votre tableau de bord !</h1>
    <p class="text-gray-700 text-lg mb-6" data-aos="fade-left">
        Vous êtes connecté en tant que 
        <strong><?= htmlspecialchars($utilisateur['email'] ?? 'Utilisateur') ?></strong>
        (<em><?= htmlspecialchars($utilisateur['role'] ?? 'Non défini') ?></em>).
    </p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Boutons du dashboard -->
        <a href="/stage" class="bg-indigo-900 text-white px-6 py-4 rounded-lg shadow hover:bg-indigo-700 text-center" data-aos="fade-right">
            📁 Voir les stages
        </a>

        <?php if ($utilisateur['role'] === 'Administrateur'): ?>
            <a href="/manage_requests" class="bg-indigo-900 text-white px-6 py-4 rounded-lg shadow hover:bg-indigo-700 text-center" data-aos="fade-up">
                👥 Gérer les demandes de stages
            </a>
        <?php endif; ?>

        <a href="/logout" class="bg-indigo-900 text-white px-6 py-4 rounded-lg shadow hover:bg-indigo-700 text-center" data-aos="fade-left">
            🔒 Déconnexion
        </a>
    </div>

    <!-- Section des statistiques -->
    <div class="mt-12 bg-gray-100 p-6 rounded-lg shadow-md" data-aos="flip-up">
        <h2 class="text-2xl font-bold text-indigo-900 mb-4">Statistiques</h2>
        <ul class="space-y-2 text-gray-700">
            <li data-aos="fade-up">📋 Nombre de stages : <?= rand(5, 50) ?></li>
            <li data-aos="fade-up">👥 Nombre d'utilisateurs : <?= rand(10, 100) ?></li>
            <li data-aos="fade-up">🏢 Nombre d'entreprises partenaires : <?= rand(3, 20) ?></li>
        </ul>
    </div>
</div>


