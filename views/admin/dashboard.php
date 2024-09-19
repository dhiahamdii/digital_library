<?php include '../templates/backoffice.php'; ?>

<h2>Tableau de bord de l'administrateur</h2>

<div class="dashboard-widgets">
    <div class="widget">
        <h3>Statistiques générales</h3>
        <ul>
            <li>Nombre total de documents : <?php echo $totalDocuments; ?></li>
            <li>Nombre total d'emprunts : <?php echo $totalEmprunts; ?></li>

        </ul>
    </div>

    <div class="widget">
    <h3>Documents les plus empruntés</h3>
    <ol>
        <?php if (!empty($topDocuments)): ?>
            <?php foreach ($topDocuments as $doc): ?>
                <li><?php echo htmlspecialchars($doc['titre']) . ' (' . $doc['emprunts'] . ' emprunts)'; ?></li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>Aucun document emprunté pour le moment.</li>
        <?php endif; ?>
    </ol>
</div>

<div class="widget">
    <h3>Emprunts en retard</h3>
    <table>
        <thead>
            <tr>
                <th>Utilisateur</th>
                <th>Document</th>
                <th>Date de retour prévue</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($lateReturns)): ?>
                <?php foreach ($lateReturns as $emprunt): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($emprunt['utilisateur_nom']); ?></td>
                        <td><?php echo htmlspecialchars($emprunt['document_titre']); ?></td>
                        <td><?php echo htmlspecialchars($emprunt['date_retour_prevue']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">Aucun emprunt en retard.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</div>

<div class="admin-actions">
    <h3>Actions rapides</h3>
    <a href="index.php?action=gererDocuments" class="btn btn-primary">Gérer les documents</a>
    <a href="index.php?action=gererEmprunts" class="btn btn-secondary">Gérer les emprunts</a>
    <a href="index.php?action=rechercheMulticritere" class="btn btn-info">Recherche multicritère</a>
</div>

<?php include '../templates/footer.php'; ?>