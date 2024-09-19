<?php include '../templates/backoffice.php'; ?>

<h2>Ajouter un Document</h2>

<?php if (isset($_GET['error'])): ?>
    <p style="color: red;">Erreur lors de l'ajout du document. Veuillez vérifier vos données.</p>
<?php elseif (isset($_GET['success'])): ?>
    <p style="color: green;">Document ajouté avec succès !</p>
<?php endif; ?>

<form action="index.php?action=ajouterDocument" method="post" onsubmit="return validateDocumentForm();">
    <div>
        <label for="titre">Titre:</label>
        <input type="text" id="titre" name="titre" >
    </div>
    
    <div>
        <label for="auteur">Auteur:</label>
        <input type="text" id="auteur" name="auteur" >
    </div>
    
    <div>
        <label for="annee">Année:</label>
        <input type="number" id="annee" name="annee"  >
    </div>
    
    <div>
        <label for="type">Type:</label>
        <select id="type" name="type">
            <option value="livre">Livre</option>
            <option value="article">Article</option>
            <option value="these">Thèse</option>
        </select>
    </div>

    <button class="btn btn-primary" type="submit">Ajouter Document</button>
</form>

<!-- Link to external JavaScript file -->
<script src="../js/form-validation.js"></script>

<?php include '../templates/footer.php'; ?>
