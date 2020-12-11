<form method="post" enctype="multipart/form-data">
    <label for="picture">Image de la catégorie :</label>
    <img src="img/category/<?= $category->getFilename(); ?>" alt="">
    </br>
    <input type="file" name="picture" id="picture">
    </br>
    <label for="title">Titre de la catégorie :</label>
    </br>
    <input type="text" name="title" id="title" value="<?= $category->getTitle(); ?>">
    </br>
    <label for="sentence">Phrase d'accroche de la catégorie :</label>
    </br>
    <textarea id="sentence" name="sentence" rows="5" cols="100"><?= $category->getSentence(); ?></textarea>
    </br>
    <label for="status">Status :</label>
    <select name="status" id="status">
        <option value="<?= $category->getStatus(); ?>">
            <?php if($category->getStatus() == 1) {
                echo 'Pricipale';
            } elseif($category->getStatus() == null) {
                echo 'Active';
            } elseif($category->getStatus() == 0) {
                echo 'Inactive';
            } ?>
        </option>
        <option>--- Choisir une option ---</option>
        <option value="1">Catégorie principale</option>
        <option value=null>Catégorie active</option>
        <option value="0">Catégorie inactive</option>
    </select>
    </br>
    <input type="hidden" name="filename" value="<?= $category->getFilename(); ?>">
    <input type="hidden" name="id" value="<?= $category->getId(); ?>">
    <input type="submit" class="btn btn-primary" name="submit" value="Modifier la catégorie">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
</form>
