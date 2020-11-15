<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- TITLE -->
        <title><?php echo $this->title; ?></title>

        <!-- LINK -->
        <?php include('../App/template/include/link.php'); ?>
    </head>
    <body>

    <!-- NAV -->
    <?php include('../App/template/include/nav.php'); ?>

    <?php include('../App/template/include/alert.php'); ?>

    <!-- CONTENT -->
    <?php echo $content; ?>

    <!-- FOOTER -->
    <?php include('../App/template/include/footer.php'); ?>

    <!-- COPYRIGHT -->
    <?php //include('../App/template/include/copyright.php'); ?>

    <!-- JS SCRIPTS -->
    <?php //include('../App/template/include/scripts.php'); ?>

    </body>
</html>