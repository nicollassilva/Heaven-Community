<?php

use App\Models\Apis\Topic;
use App\Models\Apis\Balance;
use App\Languages\GetLanguage;
use App\Boot\ForumConfiguration;

$heavenTitle = $primary['name'] . ' - ' . $secondary['name'];
$heavenBreadcrumb = ['Fórum', $primary['name'], $secondary['name']];
include dirname(__DIR__) . "/includes/header.php";

?>
<div class="container">
    <div class="general-box">
        <div class="categories-box">
            <div class="general-categorie-info">
                <span><?php echo $secondary['name'] ?></span>
                <p><?php echo $secondary['description'] ?></p>
                <hr class="my-0">
                <button class="btn btn-sm mt-3 btn-dark ml-2"><i class="fas fa-list-ol mr-2"></i><?php echo GetLanguage::get('last_topics_comments') ?></button>
                <div class="alert alert-danger">
                    Categoria fechada por 24h. <b>Motivo:</b> Os moderadores estão arrumando os posts e reorganizando tudo.
                </div>
            </div>
            <div class="general-categorie" <?php echo $secondary['bgIconColor'] ? ' style="background: var(--default-wallpaper), ' . $secondary['bgIconColor'] . '"' : '' ?>>
                <div class="icon" center><?php echo $secondary['icon'] ?></div>
                <div class="name" center><?php echo $secondary['name'] ?></div>
                <div class="minimize" center><i class="fas fa-minus"></i></div>
            </div>
            <ul class="sub-categories">
                <?php if (is_array($tertiary)) {
                    foreach ($tertiary as $subcategorie) {
                        $lastTopic = (new Topic)->lastTopic($subcategorie['id'], 'tertiary');
                        $listCategories = $quaternary((int) $subcategorie['id']);
                        $balanceCategorie = (new Balance)->getStatistics(null, $subcategorie['id']);
                        ?>
                        <li class="subcategorie">
                            <div class="icon" center<?php echo $secondary['bgIconColor'] ? ' style="background-color: ' . $secondary['bgIconColor'] . '"' : '' ?>><?php echo $subcategorie['icon'] ?></div>
                            <div class="sub-categories-cats">
                                <a class="name" href="/<?php echo $secondary['url'] ?>/<?php echo $subcategorie['url'] ?>"><?php echo $subcategorie['name'] ?></a>
                                <ul class="list-categories">
                                    <?php if (is_array($listCategories)) {
                                        foreach ($listCategories as $categorieList) { ?>
                                            <a href="<?php echo $secondary['id'] . '/' . $subcategorie['url'] . '/' . $categorieList['url'] ?>">- <?php echo $categorieList['name'] ?></a>
                                    <?php }
                                    } ?>
                                </ul>
                                <div class="statistics">
                                    <div class="topics" data-toggle="tooltip" title="Total de Tópicos" center><i class="fas fa-pencil-alt"></i><?php echo $balanceCategorie['posts'] ?? 'NaN' ?></div>
                                    <div class="views" data-toggle="tooltip" title="Total de Visualizações" center><i class="fas fa-eye"></i><?php echo $balanceCategorie['views'] ?? 'NaN' ?></div>
                                </div>
                                <span class="description"><?php echo $subcategorie['description'] ?></span>
                            </div>
                            <div class="last-post">
                            <?php if(is_array($lastTopic)) { ?>
                                <div class="photo" style="background-image: url('uploads/profiles/<?php echo $lastTopic['avatar'] ?>')"></div>
                                <div class="title text-truncate"><a href="/topic/<?php echo $lastTopic['idTopic'] . '/' . $lastTopic['url'] ?>"><?php echo ForumConfiguration::getTagForTopic(strtolower($lastTopic['type'])) ?><?php echo $lastTopic['title'] ?></a></div>
                                <div class="time"><?php echo sprintf(GetLanguage::get('time_format'), ForumConfiguration::formatTime($lastTopic['date'])) ?></div>
                                <div class="owner text-truncate"><i class="fas fa-user text-secondary mr-1"></i><a href="/user/<?php echo $lastTopic['urlProfile'] ?>"><?php echo $lastTopic['username'] ?></a></div>
                            <?php } else { echo '<span class="make-new-topic" center>' . GetLanguage::get('make_a_topic_now') . '</span>'; } ?>
                            </div>
                        </li>
                    <?php }
                } else { ?>
                    <li class="subcategorie">
                        <?php echo GetLanguage::get('categorie_secondary_not_found') ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <div class="general-right-column">
            <div class="last-activities">
                <div class="general-title" center>
                    <?php echo GetLanguage::get('last_activities_title') ?>
                </div>
                <ul class="activies">
                    <?php require dirname(__DIR__, 1) . '/includes/lastActivities.php' ?>
                </ul>
            </div>
            <div class="general-title" center>
                <?php echo GetLanguage::get('our_partners') ?>
            </div>
            <div class="partners">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide" style="background-image: url('https://i.pinimg.com/originals/de/f6/96/def69643889ee29e232637646e839064.jpg')"></div>
                        <div class="swiper-slide" style="background-image: url('https://i2.wp.com/marketingcomcafe.com.br/wp-content/uploads/2017/12/banco-imagens-gratis.png')"></div>
                        <div class="swiper-slide" style="background-image: url('https://i0.wp.com/gamelogia.com.br/wp-content/uploads/2016/11/gamer.jpg?resize=1280%2C640&ssl=1')"></div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </div>
</div>