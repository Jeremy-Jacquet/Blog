<label for="picture">Image de l'article :</label>
</br>
<img src="img/article/<?= $article->getFilename(); ?>" alt="">
<!-- Button trigger picture modal -->
</br>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updatePicture">
    Modifier l'image
</button>
<p>Titre de l'article :</p>
<p><?= $article->getTitle(); ?></p>
<!-- Button trigger title modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateTitle">
    Modifier le titre
</button>
<p>Phrase d'accroche de l'article :</p>
<p><?= $article->getSentence(); ?></p>
<!-- Button trigger sentence modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateSentence">
    Modifier la phrase d'accroche
</button>
<p>Contenu de l'article :</p>
<p><?= $article->getContent(); ?></p>
<!-- Button trigger sentence modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateContent">
    Modifier le contenu
</button>
<p>Catégorie : <?= $article->getCategoryTitle(); ?></p>
<!-- Button trigger sentence modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateCategory">
    Modifier la catégorie
</button>
<p>Status : <?= $article->getStatusName(); ?></p>
<!-- Button trigger sentence modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#updateStatus">
    Modifier le statut
</button>


<!-- Picture Modal -->
<div class="modal fade" id="updatePicture" tabindex="-1" role="dialog" aria-labelledby="updatePictureLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updatePictureLabel">Modification de l'image:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form method="post" enctype="multipart/form-data">
                <input type="file" name="picture" id="picture">
                <input type="hidden" name="picture" value="true">
                <input type="hidden" name="id" value="<?= $article->getId(); ?>">
                <input type="hidden" name="updatedUserId" value="<?= $this->session->get('id'); ?>">
                <input type="submit" class="btn btn-primary" name="submit" value="Modifier l'image">
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>

<!-- Title Modal -->
<div class="modal fade" id="updateTitle" tabindex="-1" role="dialog" aria-labelledby="updateTitleLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateTitleLabel">Modification du titre:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form method="post">
                <input type="text" name="title" id="title" value="<?= $article->getTitle(); ?>">
                <input type="hidden" name="id" value="<?= $article->getId(); ?>">
                <input type="hidden" name="updatedUserId" value="<?= $this->session->get('id'); ?>">
                <input type="submit" class="btn btn-primary" name="submit" value="Modifier le titre">
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>

<!-- Sentence Modal -->
<div class="modal fade" id="updateSentence" tabindex="-1" role="dialog" aria-labelledby="updateSentenceLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateSentenceLabel">Modification du contenu:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form method="post">
            <textarea id="sentence" name="sentence" rows="10" cols="100"><?= $article->getSentence(); ?></textarea>
                <input type="hidden" name="id" value="<?= $article->getId(); ?>">
                <input type="hidden" name="updatedUserId" value="<?= $this->session->get('id'); ?>">
                <input type="submit" class="btn btn-primary" name="submit" value="Modifier la phrase d'accroche">
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>

<!-- Content Modal -->
<div class="modal fade" id="updateContent" tabindex="-1" role="dialog" aria-labelledby="updateContentLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateContentLabel">Modification du contenu:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form method="post">
            <textarea id="content" name="content" rows="10" cols="100"><?= $article->getContent(); ?></textarea>
                <input type="hidden" name="id" value="<?= $article->getId(); ?>">
                <input type="hidden" name="updatedUserId" value="<?= $this->session->get('id'); ?>">
                <input type="submit" class="btn btn-primary" name="submit" value="Modifier le contenu">
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>

<!-- Category Modal -->
<div class="modal fade" id="updateCategory" tabindex="-1" role="dialog" aria-labelledby="updateCategoryLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateCategoryLabel">Modification du contenu:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form method="post">
                <select name="categoryId" id="categoryId">
                    <option>--- Choisir une catégorie ---</option>
                    <?php foreach($categories as $category) { ?>
                        <option value=<?= $category->getId(); ?>><?= $category->getTitle(); ?></option>
                    <?php } ?>
                </select>
                <input type="hidden" name="id" value="<?= $article->getId(); ?>">
                <input type="hidden" name="updatedUserId" value="<?= $this->session->get('id'); ?>">
                <input type="submit" class="btn btn-primary" name="submit" value="Modifier le contenu">
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>

<!-- Status Modal -->
<div class="modal fade" id="updateStatus" tabindex="-1" role="dialog" aria-labelledby="updateStatusLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateStatusLabel">Modification du statut:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form method="post">
                <label for="active">Actif</label>
                <input type="radio" id="active" name="status" value=1>
                <label for="inactive">Inactif</label>
                <input type="radio" id="inactive" name="status" value=0>
                <label for="pending">En attente</label>
                <input type="radio" id="pending" name="status" value=null>
                <input type="hidden" name="id" value="<?= $article->getId(); ?>">
                <input type="hidden" name="updatedUserId" value="<?= $this->session->get('id'); ?>">
                <input type="submit" class="btn btn-primary" name="submit" value="Modifier le contenu">
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>