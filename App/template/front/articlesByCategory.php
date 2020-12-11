<?php $this->title = 'Webaby - Articles'; ?>
<nav>
    <a href="<?= URL ?>articles&categorie=1">Developpement Web</a>
    <a href="<?= URL ?>articles&categorie=2">Sciences naturelles</a>
    <a href="<?= URL ?>articles&categorie=3">Voyages</a>
    <a href="<?= URL ?>articles&categorie=4">Jeux-vidéo</a>
    <a href="<?= URL ?>articles&categorie=5">Société</a>
</nav>

<section id="category">
    <h1 class="text-center">Articles de la catégorie <?= $category->getTitle(); ?></h1>
    <div class="border border-dark col-6 mx-auto my-3 p-3">
        <img src="img/category/<?= $category->getFilename(); ?>" alt="">
        <p><?= $category->getTitle(); ?></p>
        <p><?= $category->getSentence(); ?></p>
    </div>
</section>

<section id="articles">
    <div class="row">
        <?php foreach ($articles as $article) { ?>
            <div class="border border-dark col-6 mx-auto my-3 p-3">
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