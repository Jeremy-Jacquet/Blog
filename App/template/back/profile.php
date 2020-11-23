<?php $this->title = 'Mon profil'; ?>

<h2><?= $user->getPseudo(); ?></h2>
<img src="img/avatar/<?= $user->getFilename(); ?>" alt="">

<!-- NEWSLETTER -->
<?php if($user->getNewsletter() == 0) { ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <input type="hidden" name="newsletter" value="on">
    <input type="submit" class="btn btn-primary" name="submit" value="S'abonner à la newsletter">
</form>
<?php } else { ?>
    <form method="post" action="<?= URL ?>profil">
    <input type="hidden" name="newsletter" value="off">
    <input type="submit" class="btn btn-primary" name="submit" value="Se désabonner à la newsletter">
</form>
<?php } ?>


<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#passwordModal">
    Modifier mot de passe
</button>

<!-- Modal -->
<div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modifiez votre mot de passe</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?= URL ?>profil">
                    <label for="password">Nouveau mot de passe:</label>
                    <input type="password" name="password" id="password" required>
                    </br>
                    <label for="passwordConfirm">Confirmation du mot de passe:</label>
                    <input type="password" name="passwordConfirm" id="passwordConfirm" required>
                    </br>
                    <input type="submit" class="btn btn-primary" name="submit" value="Valider la modification">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#emailModal">
    Modifier adresse mail
</button>

<!-- Modal -->
<div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="emailModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modifiez votre adresse mail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form method="post" action="">
                    <label for="email">Nouvelle adresse mail:</label>
                    <input type="email" name="email" id="email" required>
                    </br>
                    <label for="emailConfirm">Confirmation de l'adresse mail:</label>
                    <input type="email" name="emailConfirm" id="emailConfirm" required>
                    </br>
                    <input type="submit" class="btn btn-primary" name="submit" value="Valider la modification">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                </form>
            </div>
        </div>
    </div>
</div>




<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#avatarModal">
    Modifier avatar
</button>

<!-- Modal -->
<div class="modal fade" id="avatarModal" tabindex="-1" role="dialog" aria-labelledby="avatarModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modifiez votre avatar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form method="post" action="" enctype="multipart/form-data">
                    <label for="avatar">Nouvelle image:</label>
                    <input type="file" name="avatar" id="avatar" required>
                    <input type="hidden" name="avatar" value="true">
                    </br>
                    <input type="submit" class="btn btn-primary" name="submit" value="Valider la modification">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteModal">
Supprimez mon compte
</button>

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Supprimez votre compte</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form method="post" action="">
                    <label for="deleteConfirm">Je confirme vouloir supprimer mon compte</label>
                    <input type="checkbox" name="deleteConfirm" id="deleteConfirm" value="true">
                    </br>
                    <label for="password">Validez via votre de passe:</label>
                    <input type="password" name="password" id="password" required>
                    <input type="hidden" name="delete" value="true" required>
                    <input type="submit" class="btn btn-primary" name="submit" value="Supprimer mon compte">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                </form>
            </div>
        </div>
    </div>
</div>