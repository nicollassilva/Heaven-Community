<?php

use App\Boot\ForumConfiguration;
use App\Languages\GetLanguage;

$heavenTitle = GetLanguage::get('create_new_topic');
$heavenBreadcrumb = [GetLanguage::get('topics_title'), 'Minha conta', 'Criar novo tópico'];
include dirname(__DIR__) . "/includes/header.php";

?>
<div class="container">
    <div class="general-box register-box bg-white">
        <div class="row">
            <form class="col-12 d-flex m-0 py-3" autocomplete="off" method="post">
                <div class="col col-9">
                    <div class="form-group">
                        <input id="title_topic" class="form-control" type="text" name="title" placeholder="<?php echo GetLanguage::get('new_topic_text_title') ?>">
                    </div>
                    <div class="form-group">
                        <textarea id="text_editor_textarea" class="form-control" name="text"></textarea>
                    </div>
                </div>
                <div class="col col-3">
                    <div class="form-group">
                        <select id="enable_comments" class="custom-select" name="comments">
                            <option selected><?php echo GetLanguage::get('new_topic_allow_comments') ?></option>
                            <option value="Y"><?php echo GetLanguage::get('yes') ?></option>
                            <option value="N"><?php echo GetLanguage::get('no') ?></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select id="enable_reactions" class="custom-select" name="reactions">
                            <option selected><?php echo GetLanguage::get('new_topic_allow_reactions') ?></option>
                            <option value="Y"><?php echo GetLanguage::get('yes') ?></option>
                            <option value="N"><?php echo GetLanguage::get('no') ?></option>
                        </select>
                        <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER'] ?>">
                    </div>
                    <div class="form-group">
                        <select id="type_topic" class="custom-select" name="type">
                            <option selected><?php echo GetLanguage::get('new_topic_subcategorie') ?></option>
                            <option value="C">Comum</option>
                            <option value="R"><?php echo GetLanguage::get('new_topic_request') ?></option>
                            <option value="CMS">CMS</option>
                            <option value="A"><?php echo GetLanguage::get('new_topic_help') ?></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="w-100 btn btn-success"><?php echo GetLanguage::get('button_submit_topic') ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>