<?php

use App\Boot\ForumConfiguration;
use App\Languages\GetLanguage;

$heavenTitle = GetLanguage::get('create_new_topic');
$heavenBreadcrumb = [GetLanguage::get('topics_title'), $topic['title']];
include dirname(__DIR__) . "/includes/header.php";

?>
<div class="container">
    <div class="general-box w-100 p-4 bg-white">
        <h4 class="h4 w-100 text-truncate font-weight-bold text-center mb-3"><?php echo $topic['title'] ?></h4>
        <div class="area-user" center>
            <div class="avatar" style="background-image: url('uploads/profiles/avatarDefault.webp')"></div>
            <div class="info">
                <span class="name"><a class="text-dark" href="<?php echo ForumConfiguration::getRouter('User.Profile', ['handle' => $owner['url']]) ?>"><?php echo $owner['username'] ?></a></span>
                <span class="date"><i class="fas fa-clock mr-2"></i><?php echo ForumConfiguration::formatTime($topic['date']) ?></span>
            </div>
        </div>
        <div class="topic-body">
            <?php echo htmlspecialchars_decode($topic['text']) ?>
        </div>
        <div class="topic-actions mb-5">
            <button class="like" data-toggle="tooltip" title="<?php echo GetLanguage::get('reaction.like') ?>"><i class="fas fa-thumbs-up"></i> <?php echo random_int(0, 100000) ?></button>
            <button class="love" data-toggle="tooltip" title="<?php echo GetLanguage::get('reaction.love') ?>"><i class="far fa-heart"></i> <?php echo random_int(0, 100000) ?></button>
            <button class="unlike" data-toggle="tooltip" title="<?php echo GetLanguage::get('reaction.unlike') ?>"><i class="fas fa-thumbs-down"></i> <?php echo random_int(0, 100000) ?></button>
            <div class="actions">
                <?php if(!$isOwner) { ?>
                    <a href="" class="redirect-href"><i class="fas fa-exclamation-circle mr-2"></i><?php echo GetLanguage::get('report_topic') ?></a>
                <?php } else { ?>
                    <a href="" class="redirect-href"><i class="fas fa-pencil-alt mr-2"></i><?php echo GetLanguage::get('edit_topic') ?></a>
                    <a href="" class="redirect-href"><i class="fas fa-trash mr-2"></i><?php echo GetLanguage::get('remove_topic') ?></a>
                <?php } ?>
                    <a href="" class="redirect-href"><i class="fab fa-gratipay mr-2"></i><?php echo GetLanguage::get('save_topic') ?></a>
            </div>
        </div>
        <h4 class="h4"><?php echo GetLanguage::get('comments') ?> (0)</h4>
    </div>
</div>