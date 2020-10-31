<?php $this->title = 'Accueil'; ?>

<section id="presentation">
    <div>
        <h1 class="text-center">Le blog de votre développeur</h2>
        <p class="text-center">Jérémy Jacquet</p>
        <p class="text-center">Développeur PHP /MySQL</p>
    </div>
</section>

<section id="last-articles">
    <h2 class="text-center">Derniers articles</h2>
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

<section id="categories">
    <h2 class="text-center">Categories</h2>
    <div class="row">
        <?php foreach ($categories as $category) { ?>

            <div class="border border-dark col-6 mx-auto my-3 p-3">
                <p><?= $category->getTitle(); ?></p>
                <p><?= $category->getSentence(); ?></p>
                <img src="img/category/<?= $category->getFilename(); ?>" alt="">
            </div>

        <?php } ?>
    </div>
</section>
