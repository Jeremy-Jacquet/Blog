<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title><?= $title; ?></title>

    </head>
    <body>

        <p>Bonjour <?= $pseudo ?>!</p>
        <p>
            Merci de vous êtes inscrit ;)</br>
            Afin de confirmer votre inscription veuillez cliquer sur le lien suivant: <a href="http://localhost/ocr/blog/index.php?route=email-confirmation&id=<?= $id; ?>&token=<?= $token; ?>" alt="">Valider votre compte</a>
        </p>        

    </body>
</html>