<?php

use App\Boot\ForumConfiguration;
use App\Languages\GetLanguage;

$heavenTitle = GetLanguage::get('create_new_topic');
$heavenBreadcrumb = [GetLanguage::get('topics_title'), 'Minha conta', 'Pedidos de Amizade'];
include dirname(__DIR__) . "/includes/header.php";

?>
<div class="container">
    <div class="general-box register-box bg-white">
        <div class="row">
            <form action="" class="col-12 d-flex m-0 py-3" autocomplete="off" method="post">
                <div class="col col-8">
                    <div class="form-group">
                        <input id="title_topic" class="form-control" type="text" name="title" placeholder="<?php echo GetLanguage::get('new_topic_text_title') ?>">
                    </div>
                    <div class="form-group">
                        <textarea id="text_editor_textarea" class="form-control" name="text"></textarea>
                    </div>
                </div>
                <div class="col col-4">
                    <div class="form-group">
                        <select id="enable_comments" class="custom-select" name="comments">
                            <option selected>Permitir comentários</option>
                            <option value="Y">Sim</option>
                            <option value="N">Não</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select id="enable_reactions" class="custom-select" name="reactions">
                            <option selected>Permitir reações</option>
                            <option value="Y">Sim</option>
                            <option value="N">Não</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select id="type_topic" class="custom-select" name="type">
                            <option selected>Informe o gênero do tópico</option>
                            <option value="Y">Comum</option>
                            <option value="N">Pedido</option>
                            <option value="N">CMS</option>
                            <option value="N">Ajuda</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>