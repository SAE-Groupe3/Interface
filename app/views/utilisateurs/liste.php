    <div class="container mx-auto px-6 md:px-12 py-12 bg-white shadow-md rounded-lg mt-12">
        <div class="container mx-auto px-6 md:px-12 py-12">
        <h1 class="text-4xl font-bold text-indigo-900 mb-8 text-center">Liste des Tuteurs</h1>

        <div class="bg-white shadow-md rounded-lg overflow-hidden max-w-4xl mx-auto">
            <table class="table-auto w-full">
                <thead class="bg-indigo-900 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left">Nom</th>
                        <th class="px-6 py-4 text-left">Prénom</th>
                        <th class="px-6 py-4 text-left">Email</th>
                        <th class="px-6 py-4 text-left">Rôle</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($utilisateurs as $utilisateur): ?>
                        <tr class="border-b">
                            <td class="px-6 py-4"><?= htmlspecialchars($utilisateur['nom']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($utilisateur['prenom']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($utilisateur['email']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($utilisateur['role']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php if ($_SESSION['utilisateur']['role'] === 'admin'): ?>
        <div class="mt-8">
            <a href="/utilisateur/add" class="bg-indigo-900 text-white px-6 py-3 rounded-lg shadow hover:bg-indigo-700">Ajouter un utilisateur</a>
        </div>
    <?php endif; ?>
</div>
