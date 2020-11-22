<section>
    <?php foreach($users as $user) { ?>
    <div class="border">
        <img src="img/avatar/<?= $user->getFilename(); ?>" alt="">
        <p><?= $user->getPseudo(); ?></p>
        <p><?= $user->getFlag(); ?></p>
        <p><?= ($user->getBanned() == 0)? 'Accepté' : 'Banni'; ?></p>
        <form method="post" action="<?= URL ?>admin&categorie=membres">
            <input type="hidden" name="id" value="<?= $user->getId(); ?>">
            <input type="submit" name="submit" value="Modifier l'utilisateur">
        </form>
    </div>
    <?php } ?>
</section>
