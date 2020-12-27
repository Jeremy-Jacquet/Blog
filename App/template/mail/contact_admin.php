<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
    </head>
    <body>
        <p>Bonjour Administrateur!</p>
        <p><?= ucfirst($name); ?> vient de vous envoyer le message suivant:</p>       
        <p><?= $content; ?></p>
        <p>Vous pouvez lui répondre à cette adresse:</p>
        <p><a href="mailto:webmaster@example.com"><?= $email; ?></a></p>
    </body>
</html>