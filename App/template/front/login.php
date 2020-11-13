<?php $this->title = "Connexion"; ?>
<p>Connectez-vous</p>
<?= $this->session->show('error_login'); ?>
<div>
    <form method="post" action="<?= URL ?>login" method="post">
        <label for="pseudo">Pseudo</label><br>
        <input type="text" id="pseudo" name="pseudo" value="<?= isset($post)? $post->get('pseudo') : ''; ?>"><br>
        <label for="password">Mot de passe</label><br>
        <input type="password" id="password" name="password"><br>
        <input type="submit" value="Connexion" id="submit" name="submit">
    </form>
</div>