<?php

use App\Models\Apis\Topic;
use App\Models\Apis\Balance;
use App\Languages\GetLanguage;
use App\Boot\ForumConfiguration;

$heavenTitle = $secondary['name'] . ' - ' . $tertiary['name'];
$heavenBreadcrumb = ['Fórum', $secondary['name'], $tertiary['name']];
include dirname(__DIR__, 2) . "/includes/header.php";

?>
<div class="container">
    <div class="general-box">
        <div class="categories-box">
            <div class="general-categorie-info">
                <span><?php echo $secondary['name'] . '<i class="fas fa-angle-double-right mx-2"></i>' . $tertiary['name'] ?></span>
                <p><?php echo $tertiary['description'] ?></p>
                <hr class="my-0">
                <button class="btn btn-sm mt-3 btn-dark ml-2"><i class="fas fa-list-ol mr-2"></i><?php echo GetLanguage::get('last_topics_comments') ?></button>
            </div>
            <?php if (is_array($quaternary)) { ?>
                <div class="general-categorie" <?php echo $secondary['bgIconColor'] ? ' style="background: var(--default-wallpaper), ' . $secondary['bgIconColor'] . '"' : '' ?>>
                    <div class="icon" center><?php echo $tertiary['icon'] ?></div>
                    <div class="name" center><?php echo $tertiary['name'] ?></div>
                    <div class="minimize" center><i class="fas fa-minus"></i></div>
                </div>
            <?php } else { ?>
                <div class="general-categorie">
                    <div class="name" center><i class="fas fa-angle-double-right mx-2"></i><?php echo GetLanguage::get('topics_title') ?></div>
                </div>
            <?php } ?>
            <ul class="sub-categories">
                <?php if (is_array($quaternary)) {
                    foreach ($quaternary as $categorie) {
                        $lastTopic = (new Topic)->lastTopic($categorie['id'], 'quaternary');
                        $balanceCategorie = (new Balance)->getStatistics(null, null, $categorie['id']);
                    ?>
                        <li class="subcategorie">
                            <div class="icon" style="background-color: var(--second-strong-color)" center><i class="fas fa-comment"></i></div>
                            <div class="sub-categories-cats">
                                <a class="name" href="<?php echo $secondary['id'] ?>/<?php echo $tertiary['url'] ?>/<?php echo $categorie['url'] ?>"><?php echo $categorie['name'] ?></a>
                                <div class="statistics">
                                    <div class="topics" data-toggle="tooltip" title="Total de Tópicos" center><i class="fas fa-pencil-alt"></i><?php echo $balanceCategorie['posts'] ?? 'NaN' ?></div>
                                    <div class="views" data-toggle="tooltip" title="Total de Visualizações" center><i class="fas fa-eye"></i><?php echo $balanceCategorie['views'] ?? 'NaN' ?></div>
                                </div>
                                <span class="description"><?php echo $categorie['description'] ?></span>
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
                } ?>
            </ul>
        </div>
        <div class="general-right-column">
            <div class="last-activities">
                <div class="general-title" center>
                    <?php echo GetLanguage::get('last_activities_title') ?>
                </div>
                <ul class="activies">
                    <?php require dirname(__DIR__, 2) . '/includes/lastActivities.php' ?>
                </ul>
            </div>
        </div>
    </div>
</div>