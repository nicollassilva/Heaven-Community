<?php

use App\Boot\ForumConfiguration;
use App\Languages\GetLanguage;

    $heavenTitle = 'Faça seu registro agora!';
    $heavenDescription = 'Registre-se agora no ' . ForumConfiguration::$forumName . ' e obtenha diversos conteúdos grátis e fácil!';
    $heavenBreadcrumb = ['Registro', 'Criar minha conta'];
    include "includes/header.php";
?>
<div class="container">
    <div class="general-box register-box bg-white">
        <span class="title"><?php echo GetLanguage::get('register_text_first_call') ?></span>
        <p class="text-muted"><?php echo GetLanguage::get('register_text_required_fields') ?></p>
        <p class="text-muted"><?php echo GetLanguage::get('register_text_required_fields') ?></p>
        <div class="row">
            <div class="col col-7">
                <form action="/register" method="post" class="col-12" autocomplete="off">
                    <div class="row col-12">
                        <div class="col col-6">
                            <div class="form-group">
                                <input type="text" id="username" name="username" placeholder="* <?php echo GetLanguage::get('register_text_field_username') ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="email" id="email" name="email" placeholder="* <?php echo GetLanguage::get('register_text_field_email') ?>" class="form-control">
                                <button type="button" class="btn btn-dark question" data-toggle="popover" data-placement="top" title="<?php echo GetLanguage::get('register_text_question_email') ?>" data-content="<?php echo GetLanguage::get('register_text_response_email') ?>"><i class="fas fa-question"></i></button>
                            </div>
                        </div>
                        <div class="col col-6">
                            <div class="form-group">
                                <input type="text" id="twitter" name="twitter" placeholder="<?php echo GetLanguage::get('register_text_field_twitter') ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="text" id="facebook" name="facebook" placeholder="<?php echo GetLanguage::get('register_text_field_facebook') ?>" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row col-12">
                        <div class="col col-6">
                            <div class="form-group">
                                <input type="password" id="password" name="password" placeholder="* <?php echo GetLanguage::get('register_text_field_password') ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="* <?php echo GetLanguage::get('register_text_field_confirmPassword') ?>" class="form-control">
                            </div>
                        </div>
                        <div class="col col-6">
                            <div class="form-group">
                                <input type="text" id="discord" name="discord" placeholder="<?php echo GetLanguage::get('register_text_field_discord') ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="text" id="github" name="github" placeholder="<?php echo GetLanguage::get('register_text_field_github') ?>" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row col-12">
                        <div class="col col-6">
                            <div class="form-group">
                                <select class="custom-select custom-select-sm" name="gender">
                                    <option selected>* <?php echo GetLanguage::get('register_text_choise_genders') ?></option>
                                    <option value="M"><?php echo GetLanguage::get('register_text_gender_male') ?></option>
                                    <option value="F"><?php echo GetLanguage::get('register_text_choise_female') ?></option>
                                    <option value="U"><?php echo GetLanguage::get('register_text_choise_undefined') ?></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="custom-select custom-select-sm" name="terms">
                                    <option selected>* <?php echo GetLanguage::get('register_text_choise_terms') ?></option>
                                    <option value="Y"><?php echo GetLanguage::get('register_text_agree_terms') ?></option>
                                    <option value="N"><?php echo GetLanguage::get('register_text_disagree_terms') ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col col-6">
                            <div class="form-group">
                                <input type="text" id="gitlab" name="gitlab" placeholder="<?php echo GetLanguage::get('register_text_field_gitlab') ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success col-12"><?php echo GetLanguage::get('register_text_button_register') ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col col-5 terms">
                <b>Termos & Condições</b><br /><br />
                Os moderadores deste fórum se esforçam para excluir ou editar todas as mensagens de caráter repreensível o mais rápido possível. Todavia, é impossível revistar todas as mensagens. Neste sentido, você admite que todas as mensagens postadas neste fórum exprimem o ponto de vista e a opinião dos seus respectivos autores, e não aquele dos moderadores e webmasters (exceto as mensagens enviadas por estes últimos), como conseqüência eles não podem ser responsáveis por seus discursos.<br/><br/>Este fórum utiliza cookies para guardar informações no seu computador. Estes cookies não contém nenhuma informação pessoal, eles servem apenas para melhorar o conforto da utilização. O endereço eletrônico, email, é utilizado unicamente com a finalidade de comunicar os detalhes da sua inscrição assim como a sua senha (e também para enviar uma senha em caso de esquecimento).<br/><br/>- São proibidas as mensagens agressivas ou difamatórias, os insultos ou críticas pessoais, as grosserias e vulgaridades, e mais globalmente todas mensagens falsas relativas às leis internacionais em vigor; <br/>- São proibidas as mensagens que incitem ou estimulem práticas ilegais; <br/>- Se você divulgar mensagens provenientes de outros sites da internet<br/>, verifique antes se o site em questão lhe dá este direito. Mencione o endereço do site em questão respeitando o trabalho dos seus administradores!<br/>- Ficaremos agradecidos por postar mensagens idênticas uma única vez. As repetições são desagradáveis e inúteis!<br/>- Ficaremos agradecidos pelos esforços feitos ao nível gramatical e ortográfico. O estilo de escrita sms é desaconselhado!<br/><br/>Toda a mensagem que se opõe às disposições citadas acima será editada ou excluída sem aviso prévio nem qualquer outra justificação, num prazo que dependerá da disponibilidade dos moderadores. Qualquer abuso pode implicar na quebra do contrato e expulsão do membro.<i>A internet não é um espaço anônimo, nem um lugar sem leis !</i> Nós nos reservamos a possibilidade de informar ao seu provedor de acesso à internet e/ou às autoridades judiciárias de todo comportamento mal visto. O endereço IP de cada participante à registrado a fim de ajudar no respeito à estas condições.<br/><br/><span style="color:red">Clicando em " Eu aceito " abaixo:<br/>- você reconhece ter lido inteiramente o presente regulamento;<br/>- você se compromete em respeitar sem exceção este regulamento;<br/>- você cede aos moderadores deste fórum o direito de excluir, modificar ou editar qualquer mensagem em qualquer discussão à qualquer momento.</span><br/><br/><ul> <li> Ao se cadastrar, você concorda em seguir todas as <span style="text-decoration: underline;"><a href="https://www.power-pixel.net/t57837-ppf-regras-gerais-do-forum">nossas regras gerais</a></span>. Você estará ciente dos nossos códigos de conduta e de nossas práticas, não podendo usá-las como justificativa para algum problema. Você também concordará com nossos serviços monetizadores (como anúncios e minerações). <br/> </li><li> <strong>Lembre-se de que não somos responsáveis ​​por nenhuma mensagem postada. Não acreditamos ou garantimos a precisão, integridade ou utilidade de qualquer mensagem, e não somos responsáveis ​​pelo conteúdo da mensagem</strong>.<br/> </li><li> Você concorda, através do seu uso deste serviço, que você não usará este site para publicar qualquer material que seja sabiamente falso e / ou difamatório, impreciso, abusivo, vulgar, odioso, assedia te, obsceno, profano, sexualmente orientado, ameaçador ou invasivo da privacidade de uma pessoa.<br/> </li></ul><br/>
            </div>
        </div>
    </div>
</div>