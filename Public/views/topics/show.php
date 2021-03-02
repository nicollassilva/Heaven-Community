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
                <span class="date"><i class="fas fa-clock mr-1"></i><?php echo ForumConfiguration::formatTime($topic['date']) ?></span>
            </div>
        </div>
        <div class="topic-body">
            <?php echo htmlspecialchars_decode($topic['text']) ?>
        </div>
        <div class="topic-actions">
            
        </div>
    </div>
</div>