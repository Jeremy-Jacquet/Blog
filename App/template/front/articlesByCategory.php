<?php $this->title = 'Webaby - Articles'; ?>
<nav>
    <a href="<?= URL ?>articles&category=1">Developpement Web</a>
    <a href="<?= URL ?>articles&category=2">Sciences naturelles</a>
    <a href="<?= URL ?>articles&category=3">Voyages</a>
    <a href="<?= URL ?>articles&category=4">Jeux-vidéo</a>
    <a href="<?= URL ?>articles&category=5">Société</a>
</nav>

<section id="articles">
    <h1 class="text-center">Articles de la catégorie <?= $category->getTitle(); ?></h1>
    <div class="row">
        <?php foreach ($articles as $article) { ?>
            
            <div class="border border-dark col-6 mx-auto my-3 p-3">
                <a href="<?= URL ?>article&id=<?= $article->getId(); ?>">
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