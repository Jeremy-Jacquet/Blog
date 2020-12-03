<form method="post" action="">

    <!-- PSEUDO -->
    <label for="pseudo">Pseudo:</label>
    <input type="text" name="pseudo" value="<?= $user->getPseudo(); ?>">
    <br>

    <!-- EMAIL -->
    <label for="email">Email:</label>
    <input type="email" name="email" value="<?= $user->getEmail(); ?>">
    <br>

    <!-- FILENAME -->
    <label for="avatar">Avatar:</label>
    <input type="text" name="filename" value="<?= $user->getFilename(); ?>">

    <!-- CREATED AT -->
    <p>Inscription: <?= $user->getCreatedAt(); ?></p>

    <!-- LAST CONNEXION -->
    <p>Dernière connexion: <?= $user->getLastConnection(); ?></p>

    <!-- NEWSLETTER -->
    <label for="newsletter">Abonnement à la newsletter:</label>
    <select name="newsletter" id="newsletter">
        <option value="<?= $user->getNewsletter(); ?>" selected><?= ($user->getNewsletter() == 0)? 'Non abonné' : 'abonné'; ?></option>
        <option>--- Choisir une option ---</option>
        <?= ($user->getNewsletter() == 0)? '<option value="1">Abonné</option>'  : '<option value="0">Non abonné</option>' ?>
    </select>
    <br>

    <!-- FLAG -->
    <label for="flag">Avertissements:</label>
    <input type="number" name="flag" value="<?= $user->getFlag(); ?>">
    <br>

    <!-- BAN -->
    <label for="banned">Bannissement:</label>
    <select name="banned" id="banned">
        <option value="<?= $user->getBanned(); ?>"><?= ($user->getBanned() == 0)? 'Accepté' : 'Banni'; ?></option>
        <option>--- Choisir une option ---</option>
        <?= ($user->getBanned() == 0)? '<option value="1">Banni</option>'  : '<option value="0">Accepté</option>' ?>
    </select>
    <br>

    <!-- ROLE -->
    <label for="role_id">Role:</label>
    <select name="role_id" id="role_id">
        <option value="<?= $user->getRoleId(); ?>"><?= $user->getRole() ?></option>
        <option>--- Choisir une option ---</option>
        <option value="<?= $user::VISITOR_ROLE; ?>">Visiteur</option>
        <option value="<?= $user::MEMBER_ROLE; ?>">Membre</option>
        <option value="<?= $user::AUTHOR_ROLE; ?>">Auteur</option>
        <option value="<?= $user::ADMIN_ROLE; ?>">Admin</option>
    </select>
    <br>

    <input type="hidden" name="id" value="<?= $user->getId(); ?>">
    <input type="hidden" name="update" value="true">
    <input type="submit" name="submit" value="Modifier">
</form>

<form method="post" action="">
    <input type="checkbox" name="deleteConfirm">
    <input type="hidden" name="delete" value="true">
    <input type="hidden" name="id" value="<?= $user->getId(); ?>">
    <input type="submit" name="submit" value="Supprimer le membre">
</form>