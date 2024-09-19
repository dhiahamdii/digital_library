<?php include '../templates/backoffice.php'; ?>

<h2>Gestion des Emprunts</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Utilisateur</th>
            <th>Document</th>
            <th>Date d'emprunt</th>
            <th>Date de retour prévue</th>
            <?php if ($_SESSION['user_role'] === 'bibliothecaire'): ?>

            <th>Date de retour réelle</th>
            <th>Actions</th>
            <?php endif; ?>

        </tr>
    </thead>
    <tbody>
        <?php foreach ($emprunts as $emprunt): ?>
            <tr>
                <td><?php echo htmlspecialchars($emprunt['id']); ?></td>
                <td><?php echo htmlspecialchars($emprunt['utilisateur_nom']); ?></td>
                <td><?php echo htmlspecialchars($emprunt['document_titre']); ?></td>
                <td><?php echo htmlspecialchars($emprunt['date_emprunt']); ?></td>
                <td><?php echo htmlspecialchars($emprunt['date_retour_prevue']); ?></td>
                <td>
                <?php if ($_SESSION['user_role'] === 'bibliothecaire'): ?>

                    <?php if ($emprunt['date_retour_reelle']): ?>
                        <?php echo htmlspecialchars($emprunt['date_retour_reelle']); ?>
                    <?php else: ?>
                        <form action="index.php?action=retournerDocument" method="POST">
                            <input type="hidden" name="emprunt_id" value="<?php echo $emprunt['id']; ?>">
                            <input type="date" name="date_retour" required>
                            <button type="submit" class="btn btn-primary">Retourner</button>
                        </form>
                    <?php endif; ?>
                    <?php endif; ?>

                </td>
                <?php if ($_SESSION['user_role'] === 'bibliothecaire'): ?>

                <td>
                    
                    <?php if (!$emprunt['date_retour_reelle']): ?>
                        <form action="index.php?action=prolongerEmprunt" method="POST">
                            <input type="hidden" name="emprunt_id" value="<?php echo $emprunt['id']; ?>">
                            <button type="submit" class="btn btn-secondary">Prolonger</button>
                        </form>
                    <?php endif; ?>
                </td>
                <?php endif; ?>

            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include '../templates/footer.php'; ?>