<?php
    use App\Boot\ForumConfiguration;
    use App\Controllers\WebServices\TopicController;
use App\Languages\GetLanguage;

$topicObject = new TopicController();
$lastActivities = $topicObject->lastActivities(15);
?>

<?php if (is_array($lastActivities)) {
    foreach ($lastActivities as $lastActivitie) { ?>
        <li>
            <div class="photo" style="background-image: url('/uploads/profiles/<?php echo $lastActivitie['avatar'] ?>')"></div>
            <div class="title text-truncate"><a href="/topic/<?php echo $lastActivitie['idTopic'] . '/' . $lastActivitie['url'] ?>"><?php echo ForumConfiguration::getTagForTopic(strtolower($lastActivitie['type'])) ?><?php echo $lastActivitie['title'] ?></a></div>
            <div class="time"><?php echo sprintf(GetLanguage::get('time_format'), ForumConfiguration::formatTime($lastActivitie['date'])) ?></div>
            <div class="owner text-truncate"><i class="fas fa-user text-secondary mr-1"></i><a href="/profile/<?php echo $lastActivitie['urlProfile'] ?>"><?php echo $lastActivitie['username'] ?></a></div>
        </li>
<?php }} ?>