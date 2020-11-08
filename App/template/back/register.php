<?php $this->title = 'Webaby - Inscription'; ?>
</br>
<?= isset($errors['request']) ? '<p>'.$errors['request'].'</p>' : ''; ?>

<form action="<?= URL ?>inscription" method="post">
    <label for="pseudo">Pseudo:</label>
    <input type="text" name="pseudo" id="pseudo" value="<?= isset($post) ? $post->get('pseudo') : ''; ?>" required>
    </br>
    <?= isset($errors['pseudo']) ? '<p>'.$errors['pseudo'].'</p>' : ''; ?>
    <label for="password">Mot de passe:</label>
    <input type="password" name="password" id="pseudo" required>
    </br>
    <?= isset($errors['password']) ? '<p>'.$errors['password'].'</p>' : ''; ?>
    <label for="password2">Confirmation du mot de passe:</label>
    <input type="password" name="password2" id="password2" required>
    </br>
    <?= isset($errors['password2']) ? '<p>'.$errors['password2'].'</p>' : ''; ?>
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>
    <?= isset($errors['email']) ? '<p>'.$errors['email'].'</p>' : ''; ?>
    </br>
    <input type="submit" name="submit" value="S'inscrire">
</form>