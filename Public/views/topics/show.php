<?php

use App\Boot\ForumConfiguration;
use App\Languages\GetLanguage;
use App\Models\Apis\TopicUtilities\Reactions;
use App\Models\WebServices\Web;

$heavenTitle = $topic['title'];
$heavenBreadcrumb = [GetLanguage::get('topics_title'), $topic['title']];
include dirname(__DIR__) . "/includes/header.php";

$reactions = (new Reactions)->showById($topic['id']);

?>
<div class="container">
    <div class="general-box w-100 p-4 bg-white">
        <h4 class="h4 w-100 text-truncate text-center mb-3"><?php echo $topic['title'] ?></h4>
        <div class="area-user" center>
            <div class="avatar" style="background-image: url('uploads/profiles/<?php echo $owner['avatar'] ?>')"></div>
            <div class="info">
                <span class="name"><a class="text-dark" href="<?php echo ForumConfiguration::getRouter('User.Profile', ['handle' => $owner['url']]) ?>"><?php echo $owner['username'] ?></a></span>
                <span class="date"><i class="fas fa-clock mr-2"></i><?php echo sprintf(GetLanguage::get('time_format'), ForumConfiguration::formatTime($topic['date'])) ?></span>
            </div>
        </div>
        <div class="topic-body">
            <?php echo htmlspecialchars_decode($topic['text']) ?>
        </div>
        <div class="topic-actions mb-5">
            <?php if($topic['reactions'] == 'true') { ?>
            <button class="reaction like" data-toggle="tooltip" title="<?php echo GetLanguage::get('reaction.like') ?>"><i class="fas fa-thumbs-up d-block mb-1"></i> <span><?php echo $reactions['like'] ?? 0 ?></span></button>
            <button class="reaction love" data-toggle="tooltip" title="<?php echo GetLanguage::get('reaction.love') ?>"><i class="far fa-heart d-block mb-1"></i> <span><?php echo $reactions['love'] ?? 0 ?></span></button>
            <button class="reaction unlike" data-toggle="tooltip" title="<?php echo GetLanguage::get('reaction.unlike') ?>"><i class="fas fa-thumbs-down d-block mb-1"></i> <span><?php echo $reactions['unlike'] ?? 0 ?></span></button>
            <?php } else { ?>
                <span class="topic-help float-left mt-2 px-3 py-2" style="font-size: 12px;"><i class="fas fa-times mr-2"></i><?php echo GetLanguage::get('topic_reactions_disabled') ?></span>
            <?php } ?>
            <div class="actions">
                <?php if (!$isOwner) { ?>
                    <a href="" class="redirect-href"><i class="fas fa-exclamation-circle mr-2"></i><?php echo GetLanguage::get('report_topic') ?></a>
                <?php } else { ?>
                    <a href="" class="redirect-href" editTopic><i class="fas fa-pencil-alt mr-2"></i><?php echo GetLanguage::get('edit_topic') ?></a>
                    <a href="" class="redirect-href" destroyTopic><i class="fas fa-trash mr-2"></i><?php echo GetLanguage::get('remove_topic') ?></a>
                <?php } ?>
                <a href="" class="redirect-href love"><i class="fab fa-gratipay mr-2"></i><?php echo GetLanguage::get('save_topic') ?></a>
                <?php if (isset($_SESSION['userHeavenLogged'])) { ?>
                    <a href="" class="redirect-href reply"><i class="fas fa-reply mr-2"></i><?php echo GetLanguage::get('reply_topic') ?></a>
                <?php } ?>
            </div>
        </div>
        <h4 class="h4"><?php echo GetLanguage::get('comments') ?> (<?php echo $totalComments ?>)</h4>
        <div class="topic-comments">
            <?php if(is_array($comments)) { foreach($comments as $comment) { ?>
            <div class="topic-comment">
                <div class="area-user">
                    <div class="avatar" style="background-image: url('uploads/profiles/<?php echo $comment['avatar'] ?>')"></div>
                    <div class="info">
                        <span class="name"><a class="text-dark" href="<?php echo ForumConfiguration::getRouter('User.Profile', ['handle' => $comment['url']]) ?>"><?php echo $comment['username'] ?></a></span>
                        <span class="date"><i class="fas fa-clock mr-2"></i><?php echo sprintf(GetLanguage::get('time_format'), ForumConfiguration::formatTime($comment['date'])) ?></span>
                    </div>
                    <div class="comment-actions">
                        <button data-toggle="tooltip" title="<?php echo GetLanguage::get('quote_button') ?>"><i class="fas fa-quote-left"></i></button>
                        <button data-toggle="tooltip" title="<?php echo GetLanguage::get('report_comment') ?>"><i class="fas fa-exclamation-circle"></i></button>
                        <button data-toggle="tooltip" title="<?php echo GetLanguage::get('reaction.like') ?>"><i class="fas fa-thumbs-up"></i></button>
                    </div>
                </div>
                <div class="area-comment"><?php echo htmlspecialchars_decode($comment['text']) ?></div>
            </div>
            <?php }} ?>
        </div>
    </div>
    <div class="general-box w-100 p-4 mt-0" style="min-height: 100px;">
        <div class="w-100 d-block">
            <?php echo Web::generateViewPaginate($totalComments, $page, 15) ?>
        </div>
        <h4 class="h4 my-5"><i class="fas fa-angle-double-right mr-2 text-primary"></i><?php echo GetLanguage::get('fast_reply') ?></h4>
        <div class="topic-reply">
            <?php if($topic['comments'] == 'true' && $topic['moderate'] != 'closed') { if(isset($_SESSION['userHeavenLogged'])) { ?>
            <form action="<?php echo ForumConfiguration::getRouter('Topic.Comment') ?? '' ?>" method="post" autocomplete="off">
                <div class="form-group">
                    <textarea id="text_editor_textarea" class="form-control" name="text"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="w-100 btn btn-success"><?php echo GetLanguage::get('reply_topic_button') ?></button>
                </div>
            </form>
            <?php } else { ?>
                <div class="alert alert-danger">
                    <?php echo GetLanguage::get('register_to_react') ?>
                </div>
            <?php }} else { ?>
                <div class="alert alert-danger">
                    <?php echo GetLanguage::get('topic_doesnt_accept_comments') ?>
                </div>
            <?php } ?>
            <?php if($topic['moderate'] == 'closed') { ?>
                <div class="alert alert-warning">
                    <?php echo GetLanguage::get('topic_closed_by_moderator') ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>