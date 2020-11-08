<?php
require '../vendor/autoload.php';
require '../App/config/config.php';
require '../App/config/database.php';
require '../App/config/mail.php';
$router = new App\src\blogFram\Router();
$router->run();