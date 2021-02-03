<?php

    session_start();
    date_default_timezone_set("America/Sao_Paulo");
    setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    require dirname(__DIR__, 1) . "/vendor/autoload.php";

use App\Boot\ForumConfiguration as Configuration;
use CoffeeCode\Router\Router;

Configuration::setMode();

$router = new Router(Configuration::$forumAddress, '@');
$router->namespace("App\Controllers\WebServices");

if (Configuration::$forumMaintenance) {
    $router->get("/", "WebController@maintenance", 'Web.index');
} else {
    $router->get("/", "WebController@index", "Web.index");
}

$router->dispatch();

if ($router->error() && ($_SERVER['REQUEST_METHOD'] !== 'POST')) {
    include "views/error.php";
} elseif (($_SERVER['REQUEST_METHOD'] != 'POST') && !$router->error()) {
    include "views/includes/footer.php";
}