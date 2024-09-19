<?php include '../templates/backoffice.php'; ?>

<h2>Modifier Document</h2>

<?php if (isset($_GET['error'])): ?>
    <p style="color: red;">Erreur lors de la modification du document. Veuillez vérifier vos données.</p>
<?php elseif (isset($_GET['success'])): ?>
    <p style="color: green;">Document modifié avec succès !</p>
<?php endif; ?>

<form action="index.php?action=modifierDocument&id=<?php echo $document['id']; ?>" method="post" onsubmit="return validateDocumentForm();">
    <div>
        <label for="titre">Titre:</label>
        <input type="text" id="titre" name="titre" value="<?php echo htmlspecialchars($document['titre']); ?>" >
    </div>
    
    <div>
        <label for="auteur">Auteur:</label>
        <input type="text" id="auteur" name="auteur" value="<?php echo htmlspecialchars($document['auteur']); ?>" >
    </div>
    
    <div>
        <label for="annee">Année:</label>
        <input type="number" id="annee" name="annee" value="<?php echo htmlspecialchars($document['annee']); ?>"   >
    </div>
    
    <div>
        <label for="type">Type:</label>
        <select id="type" name="type">
            <option value="livre">Livre</option>
            <option value="article">Article</option>
            <option value="these">Thèse</option>

        </select>
    </div>
    
    <button class="btn btn-primary" type="submit">Modifier Document</button>
</form>

<?php include '../templates/footer.php'; ?>
