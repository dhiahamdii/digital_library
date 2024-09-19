<?php include '../templates/frontoffice.php'; ?>

<h2>Recherche de documents</h2>

<form action="index.php?action=rechercheDocuments" method="POST" onsubmit="return validateSearchForm()">
    <div>
        <label for="titre">Titre:</label>
        <input type="text" id="titre" name="titre">
    </div>
    <div>
        <label for="auteur">Auteur:</label>
        <input type="text" id="auteur" name="auteur">
    </div>
    <div>
        <label for="annee">Année:</label>
        <input type="number" id="annee" name="annee" min="1000" max="<?php echo date('Y'); ?>">
    </div>
    <div>
        <label for="type">Type:</label>
        <select id="type" name="type">
            <option value="">Tous</option>
            <option value="livre">Livre</option>
            <option value="article">Article</option>
            <option value="these">Thèse</option>
            <option value="Book">Book</option>

        </select>
    </div>
    <button type="submit" class="btn btn-primary">Rechercher</button>
</form>

<?php if (isset($documents) && !empty($documents)): ?>
    <h3>Résultats de la recherche</h3>
    <table>
        <thead>
            <tr>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Année</th>
                <th>Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($documents as $document): ?>
                <tr>
                    <td><?php echo htmlspecialchars($document['titre']); ?></td>
                    <td><?php echo htmlspecialchars($document['auteur']); ?></td>
                    <td><?php echo htmlspecialchars($document['annee']); ?></td>
                    <td><?php echo htmlspecialchars($document['type']); ?></td>
                    <td>
                        <form action="index.php?action=emprunterDocument" method="POST">
                            <input type="hidden" name="document_id" value="<?php echo $document['id']; ?>">
                            <button type="submit" class="btn btn-secondary">Emprunter</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php elseif (isset($documents)): ?>
    <p>Aucun document trouvé.</p>
<?php endif; ?>

<script>
function validateSearchForm() {
    var annee = document.getElementById('annee').value;
    if (annee !== '' && (isNaN(annee) || annee.length !== 4)) {
        alert('L\'année doit être un nombre à 4 chiffres.');
        return false;
    }
    return true;
}
</script>

<?php include '../templates/footer.php'; ?>