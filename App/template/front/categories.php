<?php $this->title = 'Webaby - Categories'; ?>

<section id="mainCategories">
    <h1 class="text-center">Les catégories principales</h1>
    <div class="row">
        <?php foreach ($categoriesHighlight as $category) { ?>
            
            <div class="border border-dark col-6 mx-auto my-3 p-3">
                <p><?= $category->getTitle(); ?></p>
                <p><?= $category->getSentence(); ?></p>
                <img src="img/category/<?= $category->getFilename(); ?>" alt="">
            </div>

        <?php } ?>
    </div>
</section>

<section id="secondaryCategories">
    <h2 class="text-center">Les catégories secondaires</h2>
    <div class="row">
        <?php foreach ($categoriesActive as $category1) { ?>

            <div class="border border-dark col-6 mx-auto my-3 p-3">
                <p><?= $category1->getTitle(); ?></p>
                <p><?= $category1->getSentence(); ?></p>
                <img src="img/category/<?= $category1->getFilename(); ?>" alt="">
            </div>

        <?php } ?>
    </div>
</section>
