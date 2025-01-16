
<div class="container mx-auto px-6 py-12 bg-white shadow-md rounded-lg mt-12">
    <h1 class="text-3xl font-bold text-indigo-900 mb-6">Déposer un fichier</h1>

    <?php if (isset($_SESSION['upload_message'])): ?>
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded-lg mb-6">
            <?= $_SESSION['upload_message']; unset($_SESSION['upload_message']); ?>
        </div>
    <?php endif; ?>

    <?php
$stageId = isset($_GET['id_stage']) ? htmlspecialchars($_GET['id_stage']) : '';
?>

<form action="/upload-handler" method="POST" enctype="multipart/form-data" class="space-y-6">
    <input type="hidden" name="stage_id" value="<?= $stageId ?>">

    <div>
        <label for="file" class="block text-gray-700 font-bold mb-2">Choisir un fichier :</label>
        <input type="file" name="file" id="file" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400">
    </div>

    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg shadow hover:bg-indigo-500">
        Déposer le fichier
    </button>
</form>
</div>