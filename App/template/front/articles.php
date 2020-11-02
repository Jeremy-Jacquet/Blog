<?php $this->title = 'Webaby - Articles'; ?>

<h2 class="text-center">Articles par catégorie</h2>
<nav>
    <a href="<?= URL ?>articles&category=1">Developpement Web</a>
    <a href="<?= URL ?>articles&category=2">Sciences naturelles</a>
    <a href="<?= URL ?>articles&category=3">Voyages</a>
    <a href="<?= URL ?>articles&category=4">Jeux-vidéo</a>
</nav>

<section id="articles">
    <h2 class="text-center">Tous les articles</h2>
    <div class="row">
        <?php foreach ($articles as $article) { ?>
            
            <div class="border border-dark col-6 mx-auto my-3 p-3">
                <p><?= $article->getTitle(); ?></p>
                <p><?= $article->getSentence(); ?></p>
                <p><?= $article->getContent(); ?></p>
                <p><?= $article->getUserPseudo(); ?></p>
                <p><?= $article->getPublishedAt(); ?></p>
                <img src="img/article/<?= $article->getFilename(); ?>" alt="">
            </div>

        <?php } ?>
    </div>
</section>
