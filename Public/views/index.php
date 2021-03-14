<?php

use App\Boot\ForumConfiguration;
use App\Controllers\Apis\SlideController;
use App\Controllers\WebServices\TopicController;
use App\Languages\GetLanguage;
use App\Models\Apis\{
    Balance,
    Topic,
    User
};
use App\Models\Apis\TopicUtilities\Comment;
use App\Models\WebServices\Categories\Tertiary;

$topicObject = new TopicController();
$lastActivities = $topicObject->lastActivities(15);

$heavenBreadcrumb = ['Página Inicial'];
include "includes/header.php";

?>
<div class="container">
    <div class="general-box mt-0">
        <div class="cards-statistics" center>
            <div class="col col-3">
                <div class="card">
                    <i class="fas bg-dark fa-users"></i>
                    <span>
                        <p><?php echo GetLanguage::get('card_statistics_registered') ?></p><?php echo (new User)->countAllRegistered() ?>
                    </span>
                </div>
            </div>
            <div class="col col-3">
                <div class="card">
                    <i class="fas bg-danger fa-pencil-alt"></i>
                    <span>
                        <p><?php echo GetLanguage::get('card_statistics_topics') ?></p><?php echo (new Topic)->countAllTopics() ?>
                    </span>
                </div>
            </div>
            <div class="col col-3">
                <div class="card">
                    <i class="fas bg-info fa-comment"></i>
                    <span>
                        <p><?php echo GetLanguage::get('card_statistics_comments') ?></p><?php echo (new Comment)->countAllComments() ?>
                    </span>
                </div>
            </div>
            <div class="col col-3">
                <div class="card">
                    <i class="fas bg-success fa-eye"></i>
                    <span>
                        <p><?php echo GetLanguage::get('card_statistics_views') ?></p>18
                    </span>
                </div>
            </div>
        </div>
        <div class="categories-box">
            <?php if (is_array($primaryCategories)) {
                foreach ($primaryCategories as $categorie) {
                    $sub = $categorie['sub'];
                    ?>
                    <div class="general-categorie" <?php echo $categorie['backgroundColor'] ? ' style="background: var(--default-wallpaper), ' . $categorie['backgroundColor'] . '"' : '' ?>>
                        <div class="icon" center><?php echo $categorie['icon'] ?></div>
                        <div class="name" center><?php echo $categorie['name'] ?></div>
                        <div class="minimize" center><i class="fas fa-minus"></i></div>
                    </div>
                    <ul class="sub-categories">
                        <?php if (is_array($sub)) {
                            foreach ($sub as $subcategorie) {
                                $lastTopic = (new Topic)->lastTopic($subcategorie['id']);
                                $listCategories = (new Tertiary)->show($subcategorie['id']);
                                $balanceCategorie = (new Balance)->getStatistics($subcategorie['id'], null);
                            ?>
                                <li class="subcategorie">
                                    <div class="icon" center<?php echo $subcategorie['bgIconColor'] ? ' style="background-color: ' . $subcategorie['bgIconColor'] . '"' : '' ?>><?php echo $subcategorie['icon'] ?></div>
                                    <div class="sub-categories-cats">
                                        <a class="name" href="/categorie/<?php echo $subcategorie['url'] ?>"><?php echo $subcategorie['name'] ?></a>
                                        <ul class="list-categories">
                                            <?php if (is_array($listCategories)) {
                                                foreach ($listCategories as $categorieList) { ?>
                                                    <a href="<?php echo $subcategorie['url'] . '/' . $categorieList['url'] ?>">- <?php echo $categorieList['name'] ?></a>
                                                <?php }
                                            } else { ?>
                                                <ul class="list-categories">
                                                    <?php echo GetLanguage::get('categorie_tertiary_not_found') ?>
                                                </ul>
                                            <?php } ?>
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
                <?php }
            } else { ?>
                <?php echo GetLanguage::get('categorie_primary_not_found') ?>
            <?php } ?>
        </div>
        <div class="general-right-column">
            <div class="last-activities">
                <div class="general-title" center>
                    <?php echo GetLanguage::get('last_activities_title') ?>
                </div>
                <ul class="activies">
                    <?php require __DIR__ . '/includes/lastActivities.php' ?>
                </ul>
            </div>
        </div>
    </div>
</div>