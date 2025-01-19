<!-- Navigation -->
<nav class="bg-indigo-900 text-white shadow-md">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="/" class="text-white text-xl sm:text-2xl font-bold hover:text-indigo-300 transition duration-300">
                    Gestion des Stages
                </a>
            </div>

            <!-- Navigation Links - Desktop -->
            <div class="hidden lg:flex items-center space-x-8">
                <a href="/" class="text-gray-300 lg:hover:text-white transition duration-300">Accueil</a>
                <a href="/stage" class="text-gray-300 hover:text-white hover:underline transition duration-300">Stages</a>
                <a href="/dashboard" class="text-gray-300 hover:text-white hover:underline transition duration-300">Dashboard</a>
                
                <?php if (isset($_SESSION['utilisateur'])): ?>
                    <a href="/logout" class="bg-white text-indigo-900 px-4 py-2 rounded-lg shadow-md hover:bg-indigo-100 transition duration-300">
                        Déconnexion
                    </a>
                <?php else: ?>
                    <a href="/login" class="bg-white text-indigo-900 px-4 py-2 rounded-lg shadow-md hover:bg-indigo-100 transition duration-300">
                        Connexion
                    </a>
                <?php endif; ?>
            </div>

            <!-- Mobile menu button -->
            <div class="lg:hidden flex items-center">
                <button id="mobile-menu-button" class="text-gray-300 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                    <span class="sr-only">Ouvrir le menu</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div id="mobile-menu" class="hidden lg:hidden bg-indigo-800">
        <div class="p-4">
            <a href="/" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-indigo-700">Accueil</a>
            <a href="/stage" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-indigo-700">Stages</a>
            <a href="/dashboard" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-indigo-700">Dashboard</a>
            
            <?php if (isset($_SESSION['utilisateur'])): ?>
                <a href="/logout" class="block px-3 py-2 mt-4 text-center bg-white text-indigo-900 rounded-lg shadow-md hover:bg-indigo-100">
                    Déconnexion
                </a>
            <?php else: ?>
                <a href="/login" class="block px-3 py-2 mt-4 text-center bg-white text-indigo-900 rounded-lg shadow-md hover:bg-indigo-100">
                    Connexion
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!-- JavaScript pour le menu mobile -->
<script>
document.getElementById('mobile-menu-button').addEventListener('click', function() {
    const mobileMenu = document.getElementById('mobile-menu');
    mobileMenu.classList.toggle('hidden');
});

// Fermer le menu mobile lors du clic sur un lien
document.querySelectorAll('#mobile-menu a').forEach(link => {
    link.addEventListener('click', () => {
        document.getElementById('mobile-menu').classList.add('hidden');
    });
});

// Fermer le menu mobile lors du redimensionnement de la fenêtre
window.addEventListener('resize', () => {
    if (window.innerWidth >= 1024) { // 1024px est le breakpoint lg de Tailwind
        document.getElementById('mobile-menu').classList.add('hidden');
    }
});
</script>