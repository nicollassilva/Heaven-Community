<?php

use App\Boot\ForumConfiguration;
use App\Languages\GetLanguage;

$heavenTitle = 'Meus pedidos de Amizade';
$heavenBreadcrumb = ['Usuários', 'Minha conta', 'Pedidos de Amizade'];
include dirname(__DIR__) . "/includes/header.php";

?>
<div class="container">
    <div class="general-box profile-box bg-white" style="min-height: 300px">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Usuário</th>
                    <th scope="col">Online</th>
                    <th scope="col">Postado em</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if(count($requests) > 0) { foreach($requests as $request) { ?>
                    <tr>
                        <th scope="row"><?php echo $request['id'] ?></th>
                        <td><a href="<?php echo ForumConfiguration::getRouter('User.Profile', ['handle' => $request['data']['url']]) ?>" data-toggle="tooltip" title="Clique para ver o perfil"><?php echo $request['data']['username'] ?></a></td>
                        <td>há <?php echo ForumConfiguration::formatTime($request['data']['last_time']) ?> atrás</td>
                        <td><?php echo date("d-m-Y H:i", $request['date']) ?></td>
                        <td width="200">
                            <button class="btn btn-success accept"><i class="fas fa-check"></i></button>
                            <button class="btn btn-danger decline"><i class="fas fa-times"></i></button>
                        </td>
                    </tr>
                <?php }} else { ?>
                    <tr>
                        <td class="text-center text-light bg-danger" colspan="6"><i class="fas fa-times mr-2"></i><?php echo GetLanguage::get('user_no_friend_requests') ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>