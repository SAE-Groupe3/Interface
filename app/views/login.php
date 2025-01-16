<div class="container mx-auto px-6 md:px-12 py-12">
    <h1 class="text-3xl font-bold text-center text-indigo-900 mb-8">Connexion</h1>

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

<!-- Notification -->
<div id="notification" class="hidden fixed bottom-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow-md transition transform">
    Identifiants incorrects !
</div>
