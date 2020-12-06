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
            <?php if($this->session->get('id')) { ?>
                <a href="#comment">Ecrire un commentaire</a>
            <?php } else { ?>
                <p>Pour laisser un commentaire veuillez vous inscrire et vous connecter.</p>
            <?php } ?>
        </div>
    </div>
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
                    <input type="hidden" name="articleId" value="<?= $article->getId(); ?>">
                    <input type="hidden" name="userId" value="<?= $this->session->get('id'); ?>">
                    <input type="submit" name="submit" value="Envoyer le commentaire">
                </form>
            </div>
        </div>
    </section>
<?php } ?>