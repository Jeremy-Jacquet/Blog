<p>Bienvenue <?= $admin->getPseudo(); ?></p>
<img src="img/avatar/<?= $admin->getFilename(); ?>" alt="">
<p><a href="<?= URL ?>profil">Mon profil</a></p>

<!-- NAV -->
<section class="border"id="managers">
    <div>
        <a href="<?= URL ?>admin&categorie=membres">Membres</a>
        <a href="<?= URL ?>admin&categorie=articles">Articles</a>
        <a href="<?= URL ?>admin&categorie=categories">Categories</a>
        <a href="<?= URL ?>admin&categorie=commentaires">Commentaires</a>
    </div>
</section>

<!-- ADD ENTITIES -->
<section class="border"id="add_entities">
    <div>
        <a href="<?= URL ?>admin&categorie=articles&action=ajouter">Ajouter un article</a>
        <a href="<?= URL ?>admin&categorie=categories&action=ajouter">Ajouter une catégorie</a>
        <a href="<?= URL ?>admin&categorie=membres&action=ajouter">Ajouter un membre</a>
    </div>
</section>

<!-- NUMBER ELEMENTS -->
<section class="border" id="statistics">
    <div>
        <p>Statistiques:</p>
        <div>
            <p>Nombre d'utilisateurs</p>
            <p>Nombre d'articles</p>
            <p>Nombre d'auteurs</p>
            <p>Nombre de catégories</p>
            <p>Nombre de commentaires</p>
        </div>
    </div>
</section>
<!-- CLEAN DATABASE -->
<section class="border" id="clean_database">
    <div>
        <p>Nettoyage de la base de données:</p>
        <div>
            <p>Nettoyer les utilisateurs</p>
            <p>Nettoyer les articles</p>
            <p>Nettoyer les auteurs</p>
            <p>Nettoyer les catégories</p>
            <p>Nettoyer les commentaires</p>
        </div>
    </div>
</section>

<?php if($pendingArticles) { ?>
    <!-- PENDING ARTICLES -->
    <section class="border" id="pending_articles">
        <?php foreach ($pendingArticles as $article) { ?>     
            <div>
                <img src="img/article/<?= $article->getFilename(); ?>" alt="">
                <a href="<?= URL ?>admin&categorie=articles&id=<?= $article->getId(); ?>">
                    <p><?= $article->getTitle(); ?></p>
                </a>
                <p><?= $article->getCreatedAt(); ?></p>
                <p>
                    <a href="<?= URL ?>admin&categorie=membres&action=signaler&id=<?= $article->getUserId(); ?>">
                        <?= $users[$article->getUserId()]->getPseudo(); ?>
                    </a>
                </p>
            </div>
        <?php } ?>
    </section>
<?php } ?>

<?php if($pendingComments) { ?>
    <!-- PENDING COMMENTS -->
    <section class="border" id="pending_comments">
        <?php foreach ($pendingComments as $comment) { ?>
            <div>
                <p><a hreh="<?= URL ?>admin&categorie=membres&id=<? $comment->getUserId(); ?>"><?= $user[$comment->getUserId()]->getPseudo(); ?></a></p>
                <img src="img/avatar/<?= $user[$comment->getUserId()]->getFilename(); ?>" alt="">
                <a href="<?= URL ?>admin&categorie=membres&action=signaler&id=<?= $comment->getUserId(); ?>">
                    <p>Signaler le membre</p>
                </a>
                <a href="<?= URL ?>admin&categorie=membres&action=signaler&id=<?= $comment->getUserId(); ?>">
                    <p>Bannir le membre</p>
                </a>
            </div>
            <div>
                <p><?= $comment->getContent(); ?></p>
            </div>
            <div>
                <a href="<?= URL ?>admin&categorie=commentaires&action=ajouter&id=<?= $comment->getId(); ?>">
                    <p>Valider le commentaire</p>
                </a>
                <a href="<?= URL ?>admin&categorie=commentaires&action=supprimer&id=<?= $comment->getId(); ?>">
                    <p>Supprimer le commentaire</p>
                </a>
            </div>
        <?php } ?>
    </section>
<?php } ?>

