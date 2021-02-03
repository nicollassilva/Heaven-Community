<?php

use App\{
    Languages\GetLanguage,
    Boot\ForumConfiguration
};

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/reset.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/iziToast.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="assets/css/default.css">
</head>

<body>
    <header>
        <div class="menu">
            <div class="container">
                <ul>
                    <li><a href="/">Início</a></li>
                    <li><a href="#">Comunidade</a></li>
                    <li><a href="#">Fórum</a></li>
                    <li><a href="#">Usuário</a></li>
                    <div class="float-right">
                        <li>
                            <form action="" class="form-group w-100 h-100 d-flex justify-content-center align-items-center">
                                <input type="text" class="form-control input-search" placeholder="Pesquise aqui...">
                            </form>
                        </li>
                    </div>
                </ul>
            </div>
        </div>
        <div class="container">
            <div class="logo" center>
                <span>Heaven</span>
                <span>Community</span>
                <span center><?php echo ForumConfiguration::$forumTitle ?></span>
                <div class="socials" center>
                    <a href="" class="bg-dark" data-toggle="tooltip" data-placement="bottom" title="Acesse nosso Discord"><i class="fab fa-discord"></i></a>
                    <a href="" class="bg-primary" data-toggle="tooltip" data-placement="bottom" title="Acesse nosso Facebook"><i class="fab fa-facebook"></i></a>
                    <a href="" class="bg-info" data-toggle="tooltip" data-placement="bottom" title="Acesse nosso Twitter"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
            <div class="login-container">
                <div class="login-box">
                    <span>Entre no <?php echo ForumConfiguration::$forumName ?></span>
                    <span>Faça login agora</span>
                    <form action="" method="post" class="form w-100" autocomplete="off">
                        <div class="form-group">
                            <input type="text" name="username" id="name" class="form-control" placeholder="Nome de usuário">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Sua senha">
                        </div>
                        <div class="row d-flex">
                            <div class="col col-6">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="autoLogin" name="autoLogin">
                                    <label class="custom-control-label" for="autoLogin">Login automático</label>
                                </div>
                            </div>
                            <div class="col col-6">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success col-12 mt-1">Entrar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="actions">
                    <button class="btn btn-dark"><i class="fas fa-user-plus"></i> <?php echo GetLanguage::get('login_register') ?></button>
                    <button class="btn btn-danger"><i class="fas fa-question"></i> <?php echo GetLanguage::get('login_forgot_password') ?></button>
                </div>
            </div>
        </div>
    </header>
    <div class="breadcrumb-box">
        <div class="container">
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Página Inicial</li>
                </ol>
            </nav>
        </div>
    </div>