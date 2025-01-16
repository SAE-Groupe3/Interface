<nav class="bg-indigo-900 text-white px-6 py-4 shadow-md">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Logo -->
        <a href="/" class="text-white text-2xl font-bold transform hover:scale-110 transition">
            Gestion des Stages
        </a>

        <!-- Liens de navigation -->
        <div class="flex space-x-4">
            <a href="/" class="hover:text-indigo-300">Accueil</a>
            <a href="/stage" class="hover:text-indigo-300">Stages</a>
            <a href="/utilisateurs" class="hover:text-indigo-300">Utilisateurs</a>
            <a href="/dashboard" class="hover:text-indigo-300">Dashboard</a>
        </div>

        <!-- Boutons Login/Logout -->
        <div class="flex space-x-4">
            <?php if (isset($_SESSION['utilisateur'])): ?>
                <a href="/logout" class="bg-white text-indigo-900 px-4 py-2 rounded-lg shadow hover:bg-gray-100">Logout</a>
            <?php else: ?>
                <a href="/login" class="bg-white text-indigo-900 px-4 py-2 rounded-lg shadow hover:bg-gray-100">Login</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
