<?php $this->title = 'Webaby - Categories'; ?>

<section id="mainCategories">
    <h1 class="text-center">Les catégories principales</h1>
    <div class="row">
        <?php foreach ($categoriesMain as $category) { ?>
            
            <div class="border border-dark col-6 mx-auto my-3 p-3">
                <a href="<?= URL ?>articles&category=<?= $category->getId(); ?>">
                    <p><?= $category->getTitle(); ?></p>
                </a>
                <p><?= $category->getSentence(); ?></p>
                <img src="img/category/<?= $category->getFilename(); ?>" alt="">
            </div>

        <?php } ?>
    </div>
</section>

<section id="secondaryCategories">
    <h2 class="text-center">Les catégories secondaires</h2>
    <div class="row">
        <?php foreach ($categoriesActive as $category) { ?>

            <div class="border border-dark col-6 mx-auto my-3 p-3">
                <a href="<?= URL ?>articles&category=<?= $category->getId(); ?>">
                    <p><?= $category->getTitle(); ?></p>
                </a>
                <p><?= $category->getSentence(); ?></p>
                <img src="img/category/<?= $category->getFilename(); ?>" alt="">
            </div>

        <?php } ?>
    </div>
</section>
