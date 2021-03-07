<?php

use App\Languages\GetLanguage;
use App\Boot\ForumConfiguration;
use App\Models\Apis\UserUtilities\Notification;
use App\Models\Apis\User;

$userModel = new User;
$notificationModel = new Notification;

$notifications = $notificationModel->getNotifications();

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
    <meta name="logged" content="<?php echo (int) $userModel->userLogged() ?>">
    <meta property="og:image" content="<?php echo ForumConfiguration::$forumAddress ?>media/images/logonova.gif">

    <meta name="theme-color" content="#2980b9">
    <meta name="msapplication-navbutton-color" content="#2980b9">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="<?php echo ForumConfiguration::$forumTwitter ?>">
    <meta name="twitter:title" content="<?php echo $heavenTitle ?? ForumConfiguration::$forumName . ' - ' . ForumConfiguration::$forumTitle ?>!">
    <meta name="twitter:description" content="<?php echo $heavenDescription ?? ForumConfiguration::$forumDescription ?>!">
    <meta name="heavencsrftoken" content="<?php echo $_SESSION['_CSRF'] ?? '' ?>">


    <title><?php echo $heavenTitle ?? ForumConfiguration::$forumName . ' - ' . ForumConfiguration::$forumTitle ?></title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/reset.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/iziToast.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="assets/css/default.css?t=<?php echo time() ?>">

    <link rel="shortcut icon" href="./favicon.png" type="image/x-icon">
    <script src="https://cdn.tiny.cloud/1/<?php echo ForumConfiguration::$tinyMCEKey ?>/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        const _langs = {
            register_to_react: "<?php echo GetLanguage::get('register_to_react') ?>",
            error_ajax: "<?php echo GetLanguage::get('error_ajax') ?>"
        };
    </script>
</head>

<body class="animated fadeIn">
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
                <?php if (!isset($_SESSION['userHeavenLogged'])) { ?>
                    <div class="login-box">
                        <span><?php echo GetLanguage::get('login_text_span_one') . ' ' . ForumConfiguration::$forumName ?></span>
                        <span><?php echo GetLanguage::get('login_text_span_two') ?></span>
                        <form action="/login" method="post" class="form w-100" autocomplete="off" autocomplete="off">
                            <div class="form-group">
                                <input type="text" name="username" id="name" class="form-control" placeholder="<?php echo GetLanguage::get('register_text_field_username') ?>">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" id="password" class="form-control" placeholder="<?php echo GetLanguage::get('register_text_field_password') ?>">
                            </div>
                            <div class="row d-flex">
                                <div class="col col-6">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="autoLogin" name="autoLogin">
                                        <label class="custom-control-label" for="autoLogin"><?php echo GetLanguage::get('automatic_checkbox_login_label') ?></label>
                                    </div>
                                </div>
                                <div class="col col-6">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success col-12 mt-1"><?php echo GetLanguage::get('button_enter') ?> </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="actions">
                        <a href="/register" class="btn btn-dark"><i class="fas fa-user-plus"></i> <?php echo GetLanguage::get('login_register') ?></a>
                        <a class="btn btn-danger"><i class="fas fa-question"></i> <?php echo GetLanguage::get('login_forgot_password') ?></a>
                    </div>
                <?php } else { ?>
                    <div class="logged-box">
                        <div class="box-me">
                            <a class="menuLogged active" center><i class="far fa-bell"><?php echo $_SESSION['myNotifications']['c'] > 0 ? '<span class="badge badge-danger">'.$_SESSION['myNotifications']['c'].'</span>' : '' ?></i></a>
                            <a class="menuLogged messages" center><i class="far fa-envelope-open"></i></a>
                            <div class="dropdown">
                                <div class="me text-truncate"><?php echo $_SESSION['userHeavenLogged']['username'] ?><i class="fas fa-chevron-down ml-2"></i></div>
                                <div class="messages"><?php echo $_SESSION['userHeavenLogged']['comments'] . ' ' . GetLanguage::get('messages') ?></div>
                                <div class="avatar" style="background-image: url('/uploads/profiles/<?php echo $_SESSION['userHeavenLogged']['avatar'] ?>')"></div>
                                <div class="drop">
                                    <div class="name text-truncate" center><?php echo $_SESSION['userHeavenLogged']['username'] ?></div>
                                    <a href="<?php echo ForumConfiguration::getRouter('User.Profile', ['handle' => $_SESSION['userHeavenLogged']['url']]) ?>"><?php echo GetLanguage::get('user_logged_menu_text_one') ?></a>
                                    <a href=""><?php echo GetLanguage::get('user_logged_menu_text_two') ?></a>
                                    <a href=""><?php echo GetLanguage::get('user_logged_menu_text_three') ?></a>
                                    <a href=""><?php echo GetLanguage::get('user_logged_menu_text_four') ?></a>
                                    <a data-confirm="<?php echo GetLanguage::get('confirm_logout_user') ?>"><?php echo GetLanguage::get('user_logged_menu_text_five') ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="notifications">
                            <div class="box-notifications">
                                <div class="title" center><i class="fas fa-bell mr-2"></i>Minhas notificações (<?php echo $_SESSION['myNotifications']['c'] ?>)</div>
                                <ul>
                                    <?php if(is_array($notifications)) { foreach($notifications as $notification) { ?>
                                    <a href="<?php echo $notification['url'] ?>">
                                        <i class="<?php echo $notification['icon'] ?>" style="background-color: <?php echo $notification['iconColor'] ?>"></i>
                                        <span><?php echo mb_strimwidth($notification['text'], 0, 70, '...') ?></span>
                                    </a>
                                    <?php }} ?>
                                </ul>
                            </div>
                            <div class="box-notifications message">
                                <div class="title" center><i class="fas fa-envelope mr-2"></i>Minhas mensagens (2)</div>
                                <ul>
                                    <?php for($i = 0; $i < 15; $i++) { ?>
                                    <a href="">
                                        <i class="far fa-envelope"></i>
                                        <span class="mt-3"><?php echo mb_strimwidth('lyod.hp enviou uma mensagem pra você...', 0, 40, '...') ?></span>
                                    </a>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </header>
    <div class="breadcrumb-box">
        <div class="container">
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i></a></li>
                    <?php if (isset($heavenBreadcrumb)) {
                        foreach ($heavenBreadcrumb as $breadcrumb) { ?>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo $breadcrumb ?></li>
                    <?php }
                    } ?>
                </ol>
            </nav>
        </div>
    </div>