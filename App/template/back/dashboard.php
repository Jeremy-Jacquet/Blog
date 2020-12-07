<p>Bienvenue <?= $users[$this->session->get('id')]->getPseudo(); ?></p>
<img src="img/avatar/<?= $users[$this->session->get('id')]->getFilename(); ?>" alt="">
<p><a href="<?= URL ?>profil">Mon profil</a></p>

<!-- NAV -->
<section class="border" id="managers">
    <div>
        <a href="<?= URL ?>admin&categorie=membres">Membres</a>
        <a href="<?= URL ?>admin&categorie=articles">Articles</a>
        <a href="<?= URL ?>admin&categorie=categories">Categories</a>
        <a href="<?= URL ?>admin&categorie=commentaires">Commentaires</a>
    </div>
</section>

<!-- ADD ENTITIES -->
<section class="border" id="add_entities">
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
                <form action="<?= URL ?>admin&categorie=membres" method="post">
                    <input type="hidden" name="id" value="<?= $article->getUserId(); ?>">
                    <input type="submit" name="submit" value="Voir <?= $article->getUserPseudo(); ?>">
                </form>
            </div>
        <?php } ?>
    </section>
<?php } ?>

<?php if($pendingComments) { ?>
    <!-- PENDING COMMENTS -->
    <section class="border" id="pending_comments">
        <?php foreach ($pendingComments as $comment) { ?>
            <div class="border">
                <div>
                    <p><a href=""><?= $comment->getUserPseudo(); ?></a></p>
                    <img src="img/avatar/<?= $users[$comment->getUserId()]->getFilename(); ?>" alt="">
                </div>
                <div>
                    <p><?= $comment->getContent(); ?></p>
                    <p><?= $comment->getCreatedAt() ?> / <a href="<?= URL ?>articles&id=<?= $comment->getId(); ?>" target="_blank">Article n° <?= $comment->getId(); ?></a></p>
                </div>
                <div>
                    <form action="" method="post">
                        <label for="action">Modérer le commentaire:</label>
                        <select name="action" id="action">
                            <option>--- Choisir une option ---</option>
                            <option value="validate">Valider</option>
                            <option value="refuse">Refuser</option>
                            <option value="delete">Supprimer</option>
                        </select>
                        <input type="hidden" name="entity" value="comment">
                        <input type="hidden" name="id" value="<?= $comment->getId(); ?>">
                        <input type="submit" name="submit" value="Modérer">
                    </form>
                </div>
                <div>
                    <form action="" method="post">
                        <label for="action">Modérer l'utilisateur:</label>
                        <select name="action" id="action">
                            <option>--- Choisir une option ---</option>
                            <option value="flag">Signaler</option>
                            <option value="ban">Bannir</option>
                        </select>
                        <input type="hidden" name="entity" value="user">
                        <input type="hidden" name="id" value="<?= $comment->getUserId(); ?>">
                        <input type="submit" name="submit" value="Modérer">
                    </form>
                </div>
            </div>
        <?php } ?>
    </section>
<?php } ?>

