<form method="post" enctype="multipart/form-data">
    <label for="picture">Image de l'article' :</label>
    </br>
    <input type="file" name="picture" id="picture" required>
    </br>
    <label for="title">Titre de l'article :</label>
    </br>
    <input type="text" name="title" id="title">
    </br>
    <label for="sentence">Phrase d'accroche de l'article :</label>
    </br>
    <textarea id="sentence" name="sentence" rows="5" cols="100"></textarea>
    </br>
    <label for="content">Contenu de l'article :</label>
    </br>
    <textarea id="content" name="content" rows="10" cols="100"></textarea>
    </br>
    <label for="categoryId">Catégorie :</label>
    </br>
    <select name="categoryId" id="categoryId">
        <option>--- Choisir une option ---</option>
        <?php foreach($categories as $category) { ?>
            <option value=<?= $category->getId(); ?>><?= $category->getTitle(); ?></option>
        <?php } ?>
    </select>
    <p>Status :</p>
    <div>
        <label for="active">Actif</label>
        <input type="radio" id="active" name="status" value=1>
        <label for="inactive">Inactif</label>
        <input type="radio" id="inactive" name="status" value=0>
        <label for="pending">En attente</label>
        <input type="radio" id="pending" name="status" value=null>
    </div>
    <input type="hidden" name="userId" value="<?= $this->session->get('id'); ?>">
    <input type="submit" class="btn btn-primary" name="submit" value="Ajouter l'article">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
</form>
