<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Back-office - Bibliothèque Numérique</title>
    <link rel="stylesheet" href="/project/public/css/backoffice.css">
    <script src="/project/public/js/validation.js"></script>
</head>
<body>
    <header>
        <div class="container">
            <h1>Back-office - Bibliothèque Numérique</h1>
            <nav>
                <ul>
                <?php if ($_SESSION['user_role'] === 'admin'): ?>

                    <li><a href="index.php?action=adminDashboard">Tableau de bord</a></li>
                    <li><a href="index.php?action=gererDocuments">Gérer les Documents</a></li>

                    <li><a href="index.php?action=gererEmprunts">Visualise  les emprunts</a></li>
                    <?php endif; ?>
                    <?php if ($_SESSION['user_role'] === 'bibliothecaire'): ?>

                    <li><a href="index.php?action=gererDocuments">Gérer les Documents</a></li>
                    <li><a href="index.php?action=gererEmprunts">Gérer les emprunts</a></li>
                    <?php endif; ?>


                    
                    <li><a href="index.php?action=rechercheMulticritere">Recherche multicritère</a></li>
                    <li><a href="index.php">Retour au site</a></li>
                    <li><a href="index.php?action=logout">Déconnexion</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main class="container">
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">Opération réussie!</div>
        <?php endif; ?>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-error">Une erreur est survenue. Veuillez réessayer.</div>
        <?php endif; ?>
        <!-- Le contenu spécifique de chaque page sera inséré ici -->