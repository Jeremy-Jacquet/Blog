<?php
require '../vendor/autoload.php';
require '../App/config/config.php';
require '../App/config/database.php';
require '../App/config/mail.php';
session_start();

$router = new App\src\router\Router();
$router->run();