<section id="articles">
    <?php foreach($articles as $article) { ?>
        <div class="border border-dark col-6 mx-auto my-3 p-3">
            <img src="img/article/<?= $article->getFilename(); ?>" alt="">
            <p>Catégorie: <?= $article->getCategoryTitle(); ?></p>
            <p>Titre: <?= $article->getTitle(); ?></p>
            <p>Phrase d'accroche: <?= $article->getSentence(); ?></p>
            <p>Contenu: <?= $article->getContent(); ?></p>
            <p>Publié le: <?= $article->getPublishedAt(); ?></p>
            <p>Modifié le: <?= $article->getUpdatedAt(); ?></p>
            <p>Auteur: <?= $article->getUserPseudo(); ?></p>
            <p>Status: <?= $article->getStatusName(); ?></p>
            <!-- Button trigger delete modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#delete<?= $article->getId(); ?>">
                Supprimer l'article
            </button>
        </div>
    <?php } ?>
</section>

<?php foreach($articles as $article) { ?>
    <!-- Delete Modal -->
    <div class="modal fade" id="delete<?= $article->getId(); ?>" tabindex="-1" role="dialog" aria-labelledby="deleteLabel<?= $article->getId(); ?>" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteLabel<?= $article->getId(); ?>">Confirmation de la suppression de l'article</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?= URL ?>admin&categorie=articles&action=supprimer">
                    <input type="hidden" name="id" value=<?= $article->getId(); ?>>
                    <input type="submit" name="submit" value="Confirmer la suppression">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
    </div>
<?php } ?>