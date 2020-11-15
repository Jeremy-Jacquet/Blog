<?php $this->title = 'Webaby - Inscription'; ?>
</br>

<form action="<?= URL ?>inscription" method="post">
    <label for="pseudo">Pseudo:</label>
    <input type="text" name="pseudo" id="pseudo" value="<?= isset($post) ? $post->get('pseudo') : ''; ?>" required>
    </br>
    <label for="password">Mot de passe:</label>
    <input type="password" name="password" id="pseudo" required>
    </br>
    <label for="password2">Confirmation du mot de passe:</label>
    <input type="password" name="password2" id="password2" required>
    </br>
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>
    </br>
    <input type="submit" name="submit" value="S'inscrire">
</form>