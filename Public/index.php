<?php

    session_start();
    date_default_timezone_set("America/Sao_Paulo");
    setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    require dirname(__DIR__, 1) . "/vendor/autoload.php";

use CoffeeCode\Router\Router;
use App\Boot\ForumConfiguration as Configuration;
use App\Models\Apis\User;

Configuration::setMode();

$user = new User;
$userLogged = $user->userLogged();

$router = new Router(Configuration::$forumAddress, '@');
$router->namespace("App\Controllers\WebServices");

if (Configuration::$forumMaintenance) {
    $router->get("/", "WebController@maintenance", 'Web.index');
    $router->get("/rules", "WebController@rules", "Web.Rules");
} else {
    $router->get("/", "WebController@index", "Web.index");
    if (!$userLogged) {
        $router->get("/register", "WebController@register", "Web.Register");
    }

    $router->namespace("App\Controllers\Apis");

    if (!$userLogged) {
        $router->post("/register", "UserController@store", "User.Store");
        $router->post("/login", "UserController@login", "User.Login");
        $router->get("/account/verify/{token}", "UserController@verifyAccount", "User.VerifyAccount");
    } else {
        $router->post("/logout", "UserController@logout", "User.Logout");
    }
}

$router->dispatch();

if ($router->error() && ($_SERVER['REQUEST_METHOD'] !== 'POST')) {
    include "views/error.php";
} elseif (($_SERVER['REQUEST_METHOD'] != 'POST') && !$router->error()) {
    include "views/includes/footer.php";
}