<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothèque Numérique</title>
    <link rel="stylesheet" href="/project/public/css/frontoffice.css">
    <script src="/project/public/js/validation.js"></script>
</head>
<body>
    <header>
        <div class="container">
            <h1>Bibliothèque Numérique</h1>
            <nav>
                <ul>
                    <li><a href="index.php?action=rechercheDocuments">Rechercher des documents</a></li>
                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'user'): ?>

                    <li><a href="index.php?action=historiqueEmprunts">Mon historique d'emprunts</a></li>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                        <li><a href="index.php?action=adminDashboard">Administration</a></li>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="index.php?action=logout">Déconnexion</a></li>
                    <?php else: ?>
                        <li><a href="index.php?action=login">Connexion</a></li>
                    <?php endif; ?>
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