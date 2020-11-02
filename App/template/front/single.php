<section id="single">
    <div class="row">
        <div class="border border-dark col-6 mx-auto my-3 p-3">
            <a href="<?= URL ?>articles&category=<?= $article->getCategoryId(); ?>">
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
</section>
