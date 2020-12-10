<section id="categories">
    <?php foreach($categories as $category) { ?>
        <div class="border border-dark col-6 mx-auto my-3 p-3">
            <img src="img/category/<?= $category->getFilename(); ?>" alt="">
            <p><?= $category->getTitle(); ?></p>
            <p><?= $category->getSentence(); ?></p>
        </div>
    <?php } ?>
</section>