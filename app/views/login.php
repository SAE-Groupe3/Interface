<div class="container mx-auto px-6 md:px-12 py-12">
    <h1 class="text-3xl font-bold text-center text-indigo-900 mb-8">Connexion</h1>
    
    <?php if (isset($_GET['error']) && $_GET['error'] === 'true'): ?>
        <div class="flex items-center bg-red-100 text-red-800 px-4 py-3 rounded-lg mb-6 justify-center">
            <svg class="w-6 h-6 mr-2 text-red-800" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12c0 4.97-4.03 9-9 9S3 16.97 3 12 7.03 3 12 3s9 4.03 9 9z"></path>
            </svg>
            <span>Identifiants incorrects. Veuillez réessayer.</span>
            <?php if (isset($_GET['remaining'])): ?>
                <span class="ml-2 font-bold">(Tentatives restantes : <?= htmlspecialchars($_GET['remaining']); ?>)</span>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <form action="/auth/login" method="POST" class="max-w-md mx-auto bg-white shadow-md rounded-lg p-8">
        <div class="mb-6">
            <label for="email" class="block text-gray-700 font-bold">Email</label>
            <input type="email" name="email" id="email" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>
        <div class="mb-6">
            <label for="password" class="block text-gray-700 font-bold">Mot de passe</label>
            <input type="password" name="password" id="password" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
        </div>
        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg shadow hover:bg-indigo-500">Se connecter</button>
    </form>
</div>
