<?php include '../templates/frontoffice.php'; ?>

<h2>Historique des emprunts</h2>

<?php if (isset($emprunts) && !empty($emprunts)): ?>
    <table>
        <thead>
            <tr>
                <th>Titre du document</th>
                <th>Date d'emprunt</th>
                <th>Date de retour prévue</th>
                <th>Date de retour réelle</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($emprunts as $emprunt): ?>
                <tr>
                    <td><?php echo htmlspecialchars($emprunt['document_titre']); ?></td>
                    <td><?php echo htmlspecialchars($emprunt['date_emprunt']); ?></td>
                    <td><?php echo htmlspecialchars($emprunt['date_retour_prevue']); ?></td>
                    <td><?php echo $emprunt['date_retour_reelle'] ? htmlspecialchars($emprunt['date_retour_reelle']) : 'Non retourné'; ?></td>
                    <td>
                        <?php
                        if ($emprunt['date_retour_reelle']) {
                            echo 'Retourné';
                        } elseif (strtotime($emprunt['date_retour_prevue']) < time()) {
                            echo 'En retard';
                        } else {
                            echo 'En cours';
                        }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Vous n'avez pas encore emprunté de documents.</p>
<?php endif; ?>

<?php include '../templates/footer.php'; ?>