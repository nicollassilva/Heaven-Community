<?php

$heavenTitle = 'Perfil de ' . $user['username'];
$heavenBreadcrumb = ['Usuários', 'Perfil', $user['username']];
include dirname(__DIR__) . "/includes/header.php";

?>
<div class="container">
    <div class="general-box profile-box bg-white p-2">
        <div class="wallpaper" style="background-image: url('/uploads/wallpapers/<?php echo $user['wallpaper'] ?>')">
            <div class="avatar" style="background-image: url('/uploads/profiles/<?php echo $user['avatar'] ?>')">
                <?php if ($isOwner) { ?>
                    <button class="edit"><i class="fas fa-camera"></i></button>
                <?php } ?>
            </div>
            <?php if ($isOwner) { ?>
                <button class="edit"><i class="fas fa-camera"></i></button>
            <?php } ?>
        </div>
        <div class="menuProfile">
            <div class="name text-truncate">
                <?php echo $user['username'] ?>
            </div>
            <ul>
                <li class="default active">Visão Geral</li>
                <li class="friends">Amigos</li>
                <li class="topics">Tópicos</li>
            </ul>
        </div>
        <div class="box-page row d-flex default active">
            <div class="col col-4 last-ativies">
                <div class="title"><i class="far fa-user-circle mr-2"></i>Minhas informações</div>
                <ul>
                    <li style="color: <?php echo $gender['color'] ?>"><i class="<?php echo $gender['icon'] ?> mr-2"></i>Gênero <?php echo $gender['text'] ?></li>
                    <li><i class="far fa-calendar-alt text-secondary mr-2"></i>Registrou em <?php echo date("d-m-Y H:i", $user['register_time']) ?></li>
                    <li><i class="far fa-clock text-secondary mr-2"></i>Último login foi dia <?php echo date("d-m-Y \à\s H:i", $user['last_time']) ?></li>
                    <li><i class="fas fa-ticket-alt text-secondary mr-2"></i>VIP: <?php echo $user['vip'] !== null ? $user['vip'] : 'Não' ?></li>
                    <li><i class="fas fa-pencil-alt text-secondary mr-2"></i>Total de Tópicos: <?php echo $user['topics'] ?></li>
                    <li><i class="fas fa-comments text-secondary mr-2"></i>Total de Comentários: <?php echo $user['comments'] ?></li>
                    <li><i class="fab fa-facebook text-secondary mr-2"></i>Facebook: <a target="_blank" href="https://facebook.com/<?php echo $social($user['facebook']) ?>">Acesse aqui</a></li>
                    <li><i class="fab fa-twitter text-secondary mr-2"></i>Twitter: <a target="_blank" href="https://twitter.com/<?php echo $social($user['twitter']) ?>">Acesse aqui</a></li>
                    <li><i class="fab fa-discord text-secondary mr-2"></i>Discord: <b><?php echo $social($user['discord']) ?></b></li>
                    <li><i class="fab fa-github text-secondary mr-2"></i>GitHub: <a target="_blank" href="https://github.com/<?php echo $social($user['github']) ?>">Acesse aqui</a></li>
                    <li><i class="fab fa-gitlab text-secondary mr-2"></i> GitLab: <b><?php echo $social($user['gitlab']) ?></b></li>
                </ul>
            </div>
            <div class="col col-4">a</div>
            <div class="col col-4 last-ativies">
                <div class="title"><i class="fas fa-user-clock mr-2"></i>Últimas atividades</div>
                <ul>
                    <?php if (is_array($activities)) {
                        foreach ($activities as $activitie) { ?>
                            <li data-toggle="tooltip" data-placement="top" title="<?php echo $activitie['text'] ?>"><i class="far fa-clock text-secondary mr-2"></i><?php echo '<b class="mr-2">' . date("d-m-Y H:i", $activitie['date']) . ':</b>' . mb_strimwidth($activitie['text'], 0, 110, '...') ?></li>
                        <?php }
                    } else { ?>
                        <li><i class="fas fa-ban mr-2"></i>Nenhuma atividade encontrada!</li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="box-page friends row d-flex">
            <div class="menuHandle">
                <div class="btn btn-dark"><?php echo $isOwner ? 'Meus amigos' : 'Amigos de ' . $user['username'] ?><span class="badge badge-secondary ml-2">20</span></div>
                <?php if ($isOwner) { ?>
                    <div class="btn btn-success">Pedidos de Amizade <span class="badge badge-light">2</span></div>
                    <div class="btn btn-primary">Gerenciar Amizades <span class="badge badge-light"><i class="fas fa-cog"></i></span></div>
                <?php } ?>
            </div>
            <?php for ($i = 0; $i < 50; $i++) { ?>
                <div class="friend">
                    <div class="avatar-friend" style="background-image: url('uploads/profiles/avatarDefault.webp')"></div>
                    <div class="info">
                        <span class="text-truncate"><a href="/profile/">lyod.hp</a></span>
                        <span class="text-truncate">Online há 60 segundos atrás</span>
                        <?php if (!$isOwner) { ?>
                            <button class="btn btn-sm btn-success">Adicionar amigo</button>
                            <button class="btn btn-sm btn-dark ml-2" data-toggle="tooltip" title="Visitar perfil"><i class="far fa-id-card"></i></button>
                        <?php } else { ?>
                            <button class="btn btn-sm btn-success">Enviar mensagem</button>
                            <button class="btn btn-sm btn-danger ml-2" data-toggle="tooltip" title="Excluir amigo"><i class="fas fa-times"></i></button>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="box-page topics">
            <div class="menuHandle">
                <div class="btn btn-dark"><?php echo $isOwner ? 'Meus tópicos' : 'Tópicos de ' . $user['username'] ?><span class="badge badge-secondary ml-2">20</span></div>
                <?php if ($isOwner) { ?>
                    <div class="btn btn-danger">Tópicos ocultos <span class="badge badge-light">2</span></div>
                    <div class="btn btn-primary">Tópicos que sigo</div>
                <?php } ?>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Título</th>
                        <th scope="col">Postado em</th>
                        <th scope="col">Comentários</th>
                        <th scope="col">Visualizações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for($i = 0; $i < 20; $i++) { ?>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td width="180">Otto</td>
                        <td width="10">@mdo</td>
                        <td width="10">@mdo</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>