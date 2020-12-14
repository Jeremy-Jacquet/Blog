<section id="articles">
    <?php foreach($articles as $article) { ?>
        <div class="border border-dark col-6 mx-auto my-3 p-3">
            <img src="img/article/<?= $article->getFilename(); ?>" alt="">
            <p>Catégorie: <?= $article->getCategoryTitle(); ?></p>
            <p>Titre: <?= $article->getTitle(); ?></p>
            <p>Phrase d'accroche: <?= $article->getSentence(); ?></p>
            <p>Contenu: <?= $article->getContent(); ?></p>
            <p>Publié le: <?= $article->getPublishedAt(); ?></p>
            <p>Modifié le: <?= $article->getUpdatedAt(); ?></p>
            <p>Auteur: <?= $article->getUserPseudo(); ?></p>
            <p>Status: <?= $article->getStatusName(); ?></p>
        </div>
    <?php } ?>
</section>
