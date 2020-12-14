<section id="categories">
    <?php foreach($categories as $category) { ?>
        <div class="border border-dark col-6 mx-auto my-3 p-3">
            <img src="img/category/<?= $category->getFilename(); ?>" alt="">
            <p><?= $category->getTitle(); ?></p>
            <p><?= $category->getSentence(); ?></p>
            <a href="<?= URL ?>admin&categorie=categories&action=modifier&id=<?= $category->getId(); ?>">Modifier</a>
            <div>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deleteModal<?= $category->getId(); ?>">
                    Supprimer
                </button>
            </div>
        </div>
    <?php } ?>
</section>

<?php foreach($categories as $category) { ?>
    <!-- Picture Modal -->
    <div class="modal fade" id="deleteModal<?= $category->getId(); ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Souhaitez-vous vraiment supprimer la catégorie?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <p><?= $category->getTitle(); ?></p>
                    <p><?= $category->getSentence(); ?></p>
                    <form action="<?= URL ?>admin&categorie=categories&action=supprimer" method="post">
                        <input type="hidden" class="btn btn-primary" name="delete" value="true">
                        <input type="hidden" class="btn btn-primary" name="id" value="<?= $category->getId(); ?>">
                        <input type="submit" class="btn btn-primary" name="submit" value="Supprimer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
