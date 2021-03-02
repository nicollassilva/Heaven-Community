<?php

use App\Boot\ForumConfiguration;
use App\Languages\GetLanguage;

$heavenTitle = GetLanguage::get('create_new_topic');
$heavenBreadcrumb = [GetLanguage::get('topics_title'), $topic['title']];
include dirname(__DIR__) . "/includes/header.php";

?>
<div class="container">
    <div class="general-box w-100 p-4 bg-white">
        <h4 class="h4 w-100 text-truncate font-weight-bold"><?php echo $topic['title'] ?></h4>
    </div>
</div>