<?= 
($this->alert->checkErrorComment())? 
$this->alert->showErrorComment() . '<p class="text-center  m-auto"><a href="#comment">Modifier votre commentaire</a></p>' 
: ''; 
?>
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
        </div>
    </div>
    <?php if($this->session->get('id')) { ?>
        <?php if(count($comments) > 2) { ?>
            <div class="border border-dark col-6 mx-auto my-3 p-3">
            <a href="#comment">Ecrire un commentaire</a>
            </div>
        <?php } ?>
    <?php } else { ?>
            <div class="border border-dark col-6 mx-auto my-3 p-3">
            <p>Pour laisser un commentaire veuillez vous inscrire et vous connecter.</p>
            </div>
    <?php } ?>
</section>

<?php if($comments){ ?>
    <section id="comment">
        <?php foreach($comments as $comment) { ?>
            <div class="border border-dark col-6 mx-auto my-3 p-3">
                <p>
                    <img src="img/avatar/<?= $article->getFilename(); ?>" alt="">
                    <?= $users[$comment->getUserId()]->getPseudo(); ?>
                </p>
                <p>
                    <?= $comment->getContent(); ?>
                </p>
                <?php if($this->session->get('level') >= 1000) { ?>
                    <div>
                        <form action="" method="post">
                            <label for="action">Status du commentaire:</label>
                            <select name="action" id="action">
                                <option value="validate">Valide</option>
                                <option>--- Choisir une option ---</option>
                                <option value="pending">En attente</option>
                                <option value="refuse">Refuser</option>
                                <option value="delete">Supprimer</option>
                            </select>
                            <input type="hidden" name="entity" value="comment">
                            <input type="hidden" name="id" value="<?= $comment->getId(); ?>">
                            <input type="submit" name="submit" value="Modérer">
                        </form>
                    </div>
                <?php } ?>
            </div> 
        <?php } ?>
    </section>
<?php } ?>
<?php if($this->session->get('id')) { ?>
    <section id="comment">
        <div class="border border-dark col-6 mx-auto my-3 p-3">
            <div>
                <form action="" method="post">
                    <label for="comment">Laissez un commentaire</label>
                    <br>
                    <textarea id="content" name="content" rows="5" cols="33">
                        <?= ($content)? $content : ''; ?>
                    </textarea>
                    <br>
                    <input type="hidden" name="entity" value="comment">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="articleId" value="<?= $article->getId(); ?>">
                    <input type="hidden" name="userId" value="<?= $this->session->get('id'); ?>">
                    <input type="submit" name="submit" value="Envoyer le commentaire">
                </form>
            </div>
        </div>
    </section>
<?php } ?>