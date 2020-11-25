<?php $this->title = "Connexion"; ?>
<p>Connectez-vous</p>
<div>
    <form method="post" action="<?= URL ?>connexion" method="post">
        <label for="pseudo">Pseudo</label><br>
        <input type="text" id="pseudo" name="pseudo" value="<?= isset($post)? $post->get('pseudo') : ''; ?>" required><br>
        <label for="password">Mot de passe</label><br>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" name="submit" value="login">
    </form>
</div>