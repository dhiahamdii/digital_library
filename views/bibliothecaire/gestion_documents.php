<?php include '../templates/backoffice.php'; ?>

<h2>Gestion des Documents</h2>

<a href="index.php?action=ajouterDocument" class="btn btn-primary">Ajouter un nouveau document</a>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Titre</th>
            <th>Auteur</th>
            <th>Année</th>
            <th>Type</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($documents as $document): ?>
            <tr>
                <td><?php echo htmlspecialchars($document['id']); ?></td>
                <td><?php echo htmlspecialchars($document['titre']); ?></td>
                <td><?php echo htmlspecialchars($document['auteur']); ?></td>
                <td><?php echo htmlspecialchars($document['annee']); ?></td>
                <td><?php echo htmlspecialchars($document['type']); ?></td>
                <td>
                    <a href="index.php?action=modifierDocument&id=<?php echo $document['id']; ?>" class="btn btn-secondary">Modifier</a>
                    <form action="index.php?action=supprimerDocument" method="POST" style="display: inline;">
                        <input type="hidden" name="document_id" value="<?php echo $document['id']; ?>">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce document ?');">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include '../templates/footer.php'; ?>