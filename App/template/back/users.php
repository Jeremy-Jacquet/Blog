<section>
    <?php foreach($users as $user) { ?>
    <div class="border">
        <img src="img/avatar/<?= $user->getFilename(); ?>" alt="">
        <p><?= $user->getPseudo(); ?></p>
        <p><?= $user->getFlag(); ?></p>
        <p><?= ($user->getBanned() == 0)? 'Accepté' : 'Banni'; ?></p>
        <form method="post" action="">
            <input type="hidden" name="id" value="<?= $user->getId(); ?>">
            <input type="submit" name="submit" value="Modifier l'utilisateur">
        </form>
        <form method="post" action="">
            <input type="checkbox" name="deleteConfirm">
            <input type="hidden" name="delete" value="true">
            <input type="hidden" name="id" value="<?= $user->getId(); ?>">
            <input type="submit" name="submit" value="Supprimer le membre">
        </form>
    </div>
    <?php } ?>
</section>
