<?php

use App\{
    Languages\GetLanguage,
    Boot\ForumConfiguration
};

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="UTF-8">
    <base href="/">

    <meta name="author" content="Nícollas Silva - Nicollas#8412 @Dont remove this credits">
    <meta name="title" content="<?php echo $heavenTitle ?? ForumConfiguration::$forumName . ' - ' . ForumConfiguration::$forumTitle ?>!">
    <meta name="description" content="<?php echo $heavenDescription ?? ForumConfiguration::$forumDescription ?>!">
    <meta name="keywords" content="<?php echo ForumConfiguration::$forumKeywords ?>">
    <meta name="rating" content="Geral">
    <meta name="robots" content="index,follow">

    <meta property="og:title" content="<?php echo $heavenTitle ?? ForumConfiguration::$forumName . ' - ' . ForumConfiguration::$forumTitle ?>!">
    <meta property="og:url" content="<?php echo ForumConfiguration::$forumAddress ?>">
    <meta property="og:image" content="<?php echo ForumConfiguration::$forumAddress ?>media/images/logonova.gif">

    <meta name="theme-color" content="#2980b9">
    <meta name="msapplication-navbutton-color" content="#2980b9">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="<?php echo ForumConfiguration::$forumTwitter ?>">
    <meta name="twitter:title" content="<?php echo $heavenTitle ?? ForumConfiguration::$forumName . ' - ' . ForumConfiguration::$forumTitle ?>!">
    <meta name="twitter:description" content="<?php echo $heavenDescription ?? ForumConfiguration::$forumDescription ?>!">


    <title><?php echo $heavenTitle ?? ForumConfiguration::$forumName . ' - ' . ForumConfiguration::$forumTitle ?></title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/reset.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/iziToast.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="assets/css/default.css">
    
    <link rel="shortcut icon" href="./favicon.png" type="image/x-icon">
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
                    <a href="/register" class="btn btn-dark"><i class="fas fa-user-plus"></i> <?php echo GetLanguage::get('login_register') ?></a>
                    <a class="btn btn-danger"><i class="fas fa-question"></i> <?php echo GetLanguage::get('login_forgot_password') ?></a>
                </div>
            </div>
        </div>
    </header>
    <div class="breadcrumb-box">
        <div class="container">
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
                    <?php if(isset($heavenBreadcrumb)) { foreach($heavenBreadcrumb as $breadcrumb) { ?>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $breadcrumb ?></li>
                    <?php }} ?>
                </ol>
            </nav>
        </div>
    </div>