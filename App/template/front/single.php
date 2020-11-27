<section id="single">
    <div class="row">
        <div class="border border-dark col-6 mx-auto my-3 p-3">
            <a href="<?= URL ?>articles&categorie=<?= $article->getCategoryId(); ?>">
                <p><?= $article->getCategoryTitle(); ?></p>
            </a>
            <p><?= $article->getTitle(); ?></p>
            <p><?= $article->getSentence(); ?></p>
            <p><?= $article->getContent(); ?></p>
            <p><?= $article->getUserPseudo(); ?></p>
            <p><?= $article->getPublishedAt(); ?></p>
            <img src="img/article/<?= $article->getFilename(); ?>" alt="">
            <a href="#comment">Ecrire un commentaire</a>
        </div>
    </div>
</section>



<section id="comment">
    <div class="border border-dark col-6 mx-auto my-3 p-3">
        <div>
            <?php if(!$this->session->get('id')) { ?>
                <p>Attention: vous devez être inscrit et connecté pour accéder à cette fonctionnalité.</p>
            <?php } ?>
            <form action="<?= URL ?>articles&action=commenter&id=<?= $article->getId(); ?>" method="post">
                <label for="comment">Laissez un commentaire</label>
                <br>
                <?= ($this->alert->checkErrorComment())? $this->alert->showErrorComment() : ''; ?>
                <textarea id="comment" name="comment" rows="5" cols="33">
                    <?= ($comment)? $comment : ''; ?>
                </textarea>
                <br>
                <input type="hidden" name="articleId" value="<?= $article->getId(); ?>">
                <input type="hidden" name="userId" value="<?= $this->session->get('id'); ?>">
                <input type="submit" name="submit" value="Envoyer le commentaire">
            </form>
        </div>
    </div>
</section>