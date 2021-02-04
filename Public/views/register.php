<?php

use App\Boot\ForumConfiguration;
use App\Languages\GetLanguage;

$heavenTitle = 'Faça seu registro agora!';
$heavenDescription = 'Registre-se agora no ' . ForumConfiguration::$forumName . ' e obtenha diversos conteúdos grátis e fácil!';
$heavenBreadcrumb = ['Registro', 'Aceitar os Termos e Condições'];
include "includes/header.php";
?>
<div class="container">
    <div class="general-box register-box bg-white">
        <span><?php echo GetLanguage::get('register_text_first_call') ?></span>
        <p class="text-muted"><?php echo GetLanguage::get('register_text_required_fields') ?></p>
        <div class="row col-8">
            <form action="" method="post" class="col-12" autocomplete="off">
                <div class="row col-12">
                    <div class="col col-6">
                        <div class="form-group">
                            <input type="text" id="username" name="username" placeholder="* Nome de usuário" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="email" id="email" name="email" placeholder="* Endereço de e-mail" class="form-control">
                            <button type="button" class="btn btn-dark question" data-toggle="popover" data-placement="top" title="<?php echo GetLanguage::get('register_text_question_email') ?>" data-content="<?php echo GetLanguage::get('register_text_response_email') ?>"><i class="fas fa-question"></i></button>
                        </div>
                    </div>
                    <div class="col col-6">
                        <div class="form-group">
                            <input type="text" id="twitter" name="twitter" placeholder="Seu twitter" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="text" id="facebook" name="facebook" placeholder="Seu facebook" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row col-12">
                    <div class="col col-6">
                        <div class="form-group">
                            <input type="password" id="password" name="password" placeholder="* Sua senha" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="password" id="confirmPassword" name="confirmPassword" placeholder="* Confirme sua senha" class="form-control">
                        </div>
                    </div>
                    <div class="col col-6">
                        <div class="form-group">
                            <input type="text" id="discord" name="discord" placeholder="Seu discord" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="text" id="github" name="github" placeholder="Seu github" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row col-12">
                    <div class="col col-6">
                        <div class="form-group">
                            <select class="custom-select custom-select-sm">
                                <option selected>* <?php echo GetLanguage::get('register_text_choise_genders') ?></option>
                                <option value="1"><?php echo GetLanguage::get('register_text_gender_male') ?></option>
                                <option value="2"><?php echo GetLanguage::get('register_text_choise_female') ?></option>
                                <option value="3"><?php echo GetLanguage::get('register_text_choise_undefined') ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="custom-select custom-select-sm">
                                <option selected>* <?php echo GetLanguage::get('register_text_choise_terms') ?></option>
                                <option value="1"><?php echo GetLanguage::get('register_text_agree_terms') ?></option>
                                <option value="2"><?php echo GetLanguage::get('register_text_disagree_terms') ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col col-6">
                        <div class="form-group">
                            <input type="text" id="gitlab" name="gitlab" placeholder="Seu gitlab" class="form-control">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success col-12">Cadastrar agora</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>