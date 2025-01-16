<?php
ob_start();
session_start();
// Ignorer les requêtes pour favicon.ico
$uri = trim($_SERVER['REQUEST_URI'], '/');
if ($uri === 'favicon.ico') {
    return;
}
?>

<!-- Wrapper principal -->
<div class="flex flex-col min-h-screen">

    <!-- Inclure le header -->
    <?php include '../public/frontend/components/header.php'; ?>

    <!-- Connexion à la base de données -->
    <?php require_once __DIR__ . '/../config/db.php'; ?>

    <?php include 'frontend/components/navbar.php'; ?>  

    

    

    <!-- Contenu principal avec padding bas -->
    <main class="flex-grow pb-20 mb-20">
        <?php
        
        // Gestion des routes
        $uriParts = explode('?', $uri); // Séparer le chemin de la query string
        $path = $uriParts[0]; // Utiliser le chemin sans les paramètres

        switch ($path) {
            case '':
            case 'index.php':
                // Inclure la page d'accueil
                include '../views/home.php';
                break;

            case 'stage':
                include '../routes/stages.php';
                break;

            case 'stage/details':
                // Détails d'un stage
                require_once '../routes/stage_details.php';
                break;
            
            case 'login':
                include '../views/login.php';
                break;
            
            case 'auth/login':
                require_once '../routes/auth.php';
                break;
            
            case 'logout':
                require_once '../routes/logout.php';
                break;

            case 'upload':
                include '../views/upload.php';
                break;
            
            case 'upload-handler':
                include '../routes/upload_handler.php';
                break;
            
            case 'utilisateurs':
                // Liste des utilisateurs
                require_once '../routes/utilisateurs.php';
                break;


            case 'dashboard':
                if (!isset($_SESSION['utilisateur'])) {
                        header('Location: /login');
                        exit();
                    }
                include '../views/dashboard.php';
                break;

            default:
                // Page 404
                include 'frontend/components/header.php';
                echo "<div class='container mx-auto p-8'>
                        <h1 class='text-4xl font-bold text-center text-red-600 mb-8'>Page non trouvée (404)</h1>
                      </div>";
                break;
        }
        ?>
    </main>

    <!-- Footer -->
    <?php include 'frontend/components/footer.php'; ?>

    

</div>
