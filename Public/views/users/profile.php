<?php

use App\Models\Apis\User;

$heavenTitle = 'Perfil de ' . $user['username'];
$heavenBreadcrumb = ['Usuários', 'Perfil', $user['username']];
include dirname(__DIR__) . "/includes/header.php";

?>
<div class="container">
    <div class="general-box profile-box bg-white p-2">
        <div class="wallpaper" style="background-image: url('/uploads/wallpapers/<?php echo $user['wallpaper'] ?>')">
            <div class="avatar" style="background-image: url('/uploads/profiles/<?php echo $user['avatar'] ?>')">
                <?php if($isOwner) { ?>
                <button class="edit"><i class="fas fa-camera"></i></button>
                <?php } ?>
            </div>
            <?php if($isOwner) { ?>
                <button class="edit"><i class="fas fa-camera"></i></button>
            <?php } ?>
        </div>
        <div class="menuProfile">
            <div class="name text-truncate">
                <?php echo $user['username'] ?>
            </div>
            <ul>
                <li class="active">Visão Geral</li>
                <li>Amigos</li>
                <li>Tópicos</li>
            </ul>
        </div>
        <div class="box-page row d-flex">
            <div class="col col-4 last-ativies">
                <div class="title"><i class="far fa-user-circle mr-2"></i>Minhas informações</div>
                <ul>
                    <li style="color: <?php echo $gender['color'] ?>"><i class="<?php echo $gender['icon'] ?> mr-2"></i>Gênero <?php echo $gender['text'] ?></li>
                    <li><i class="far fa-calendar-alt text-secondary mr-2"></i>Registrou em <?php echo date("d-m-Y H:i", $user['register_time']) ?></li>
                    <li><i class="far fa-clock text-secondary mr-2"></i>Último login foi dia <?php echo date("d-m-Y \à\s H:i", $user['last_time']) ?></li>
                    <li><i class="fas fa-ticket-alt text-secondary mr-2"></i>VIP: <?php echo $user['vip'] !== null ? $user['vip'] : 'Não' ?></li>
                    <li><i class="fas fa-pencil-alt text-secondary mr-2"></i>Total de Tópicos: <?php echo $user['topics'] ?></li>
                    <li><i class="fas fa-comments text-secondary mr-2"></i>Total de Comentários: <?php echo $user['comments'] ?></li>
                    <li><i class="fab fa-facebook text-secondary mr-2"></i>Facebook: <a href="<?php echo $social($user['facebook']) ?>">Acesse aqui</a></li>
                    <li><i class="fab fa-twitter text-secondary mr-2"></i>Twitter: <a href="<?php echo $social($user['twitter']) ?>">Acesse aqui</a></li>
                    <li><i class="fab fa-discord text-secondary mr-2"></i>Discord: <a href="<?php echo $social($user['discord']) ?>">Acesse aqui</a></li>
                    <li><i class="fab fa-github text-secondary mr-2"></i>GitHub: <a href="<?php echo $social($user['github']) ?>">Acesse aqui</a></li>
                    <li><i class="fab fa-gitlab text-secondary mr-2"></i> GitLab: <a href="<?php echo $social($user['gitlab']) ?>">Acesse aqui</a></li>
                </ul>
            </div>
            <div class="col col-4">a</div>
            <div class="col col-4 last-ativies">
            <div class="title"><i class="fas fa-user-clock mr-2"></i>Últimas atividades</div>
                <ul>
                    <li>op akspdo kaspo dkpas kodpaosk poskdop kapd opaskdp oaskdposak pdoask dpoask pdoksp aokdos</li>
                    <li>op akspdo kaspo dkpas kodpaosk poskdop kapd opaskdp oaskdposak pdoask dpoask pdoksp aokdos</li>
                    <li>op akspdo kaspo dkpas kodpaosk poskdop kapd opaskdp oaskdposak pdoask dpoask pdoksp aokdos</li>
                    <li>op akspdo kaspo dkpas kodpaosk poskdop kapd opaskdp oaskdposak pdoask dpoask pdoksp aokdos</li>
                    <li>op akspdo kaspo dkpas kodpaosk poskdop kapd opaskdp oaskdposak pdoask dpoask pdoksp aokdos</li>
                    <li>op akspdo kaspo dkpas kodpaosk poskdop kapd opaskdp oaskdposak pdoask dpoask pdoksp aokdos</li>
                    <li>op akspdo kaspo dkpas kodpaosk poskdop kapd opaskdp oaskdposak pdoask dpoask pdoksp aokdos</li>
                    <li>op akspdo kaspo dkpas kodpaosk poskdop kapd opaskdp oaskdposak pdoask dpoask pdoksp aokdos</li>
                    <li>op akspdo kaspo dkpas kodpaosk poskdop kapd opaskdp oaskdposak pdoask dpoask pdoksp aokdos</li>
                    <li>op akspdo kaspo dkpas kodpaosk poskdop kapd opaskdp oaskdposak pdoask dpoask pdoksp aokdos</li>
                    <li>op akspdo kaspo dkpas kodpaosk poskdop kapd opaskdp oaskdposak pdoask dpoask pdoksp aokdos</li>
                    <li>op akspdo kaspo dkpas kodpaosk poskdop kapd opaskdp oaskdposak pdoask dpoask pdoksp aokdos</li>
                    <li>op akspdo kaspo dkpas kodpaosk poskdop kapd opaskdp oaskdposak pdoask dpoask pdoksp aokdos</li>
                    <li>op akspdo kaspo dkpas kodpaosk poskdop kapd opaskdp oaskdposak pdoask dpoask pdoksp aokdos</li>
                    <li>op akspdo kaspo dkpas kodpaosk poskdop kapd opaskdp oaskdposak pdoask dpoask pdoksp aokdos</li>
                </ul>
            </div>
        </div>
    </div>
</div>