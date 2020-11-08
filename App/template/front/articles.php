<?php $this->title = 'Webaby - Articles'; ?>

<nav>
    <a href="<?= URL ?>articles&categorie=1">Developpement Web</a>
    <a href="<?= URL ?>articles&categorie=2">Sciences naturelles</a>
    <a href="<?= URL ?>articles&categorie=3">Voyages</a>
    <a href="<?= URL ?>articles&categorie=4">Jeux-vidéo</a>
</nav>

<section id="articles">
    <h2 class="text-center">Tous les articles</h2>
    <div class="row">
        <?php foreach ($articles as $article) { ?>
            
            <div class="border border-dark col-6 mx-auto my-3 p-3">
                <a href="<?= URL ?>articles&categorie=<?= $article->getCategoryId(); ?>">
                    <p><?= $article->getCategoryTitle(); ?></p>
                </a>
                <a href="<?= URL ?>articles&id=<?= $article->getId(); ?>">
                    <p><?= $article->getTitle(); ?></p>
                </a>
                <p><?= $article->getSentence(); ?></p>
                <p><?= $article->getContent(); ?></p>
                <p><?= $article->getUserPseudo(); ?></p>
                <p><?= $article->getPublishedAt(); ?></p>
                <img src="img/article/<?= $article->getFilename(); ?>" alt="">
            </div>

        <?php } ?>
    </div>
</section>
