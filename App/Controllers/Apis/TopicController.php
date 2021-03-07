<?php

namespace App\Controllers\Apis;

use Exception;
use App\Models\Apis\{
    User,
    Topic,
    Balance,
    TopicUtilities\Comment,
    UserUtilities\Notification,
    TopicUtilities\LastActivities,
    TopicUtilities\Reactions
};
use App\Languages\GetLanguage;
use App\Core\Utils\BaseApiController;
use App\Models\WebServices\Categories\Union;
use App\Controllers\_interfaces\WebApisControllerInterface;

class TopicController extends BaseApiController implements WebApisControllerInterface
{
    protected $router;
    protected $model;
    protected $user;
    protected $unionCategory;
    protected $commentSystem;
    protected $lastActivitiesSystem;
    protected $notificationSystem;
    protected $notificationCommentIconColors = ['#f0932b', '#eb4d4b', '#be2edd', '#22a6b3', '#30336b', '#f9ca24'];
    protected $reactionSystem;
    

    function __construct(Object $router)
    {
        $this->router = $router;
        $this->model = new Topic;
        $this->user = new User;
        $this->unionCategory = new Union;
        $this->commentSystem = new Comment;
        $this->lastActivitiesSystem = new LastActivities;
        $this->notificationSystem = new Notification;
        $this->reactionSystem = new Reactions;
    }

    public function store(array $data)
    {
        $response = $this->model->shield($data);
        $validation = $this->model->validateStore($response);

        if (is_array($validation))
            return $this->response($validation[0]);

        $delay = $this->model->findToDelay();
        $ipBan = $this->user->findBanByIp();

        if ($delay)
            return $this->response(GetLanguage::get('wait_5_minutes_for_new_topic'));

        if ($ipBan)
            return $this->response(GetLanguage::get('user_banned_by_ip'));

        $refererExist = $this->model->separateReferer($response['referer']);

        if (!$refererExist)
            return $this->response(GetLanguage::get('new_topic_store_error'));

        $category = $this->unionCategory
            ->logicUrl(...$refererExist);

        if (!$category)
            return $this->response(GetLanguage::get('new_topic_invalid_referer_url'));

        $response['categoryId'] = isset($category['quaternary']['id']) ? $category['quaternary']['id'] : (isset($category['tertiary']['id']) ? $category['tertiary']['id'] : null);

        try {
            $newTopic = $this->model->new($response);

            if ($newTopic) {
                $lastTopic = (new Topic)->orderBy('id', 'DESC')->limit(1)->execute();
                $realCategories = $this->unionCategory->getCategoriesByQuaternary($lastTopic['category']);
                $this->user->updateBalance($_SESSION['userHeavenLogged']['id'], 'topics');
                
                if(is_array($realCategories)) {
                    $this->lastActivitiesSystem->store($lastTopic['id'], $realCategories);
                }
                
                return $this->response(
                    GetLanguage::get('new_topic_store_success'),
                    "success"
                );

                (new Balance)->increment(
                    null,
                    (isset($category['tertiary']['id']) ? (int) $category['tertiary']['id'] : null),
                    (isset($category['quaternary']['id']) ? (int) $category['quaternary']['id'] : null)
                );
            }

            return $this->response(GetLanguage::get('new_topic_store_error'));
        } catch (Exception $error) {
            return $this
                ->response(GetLanguage::get('new_topic_store_error'));
        }
    }

    public function comment(array $data)
    {
        $response = $this->model->shield($data);
        $validate = $this->commentSystem->validateStore($response);

        if (is_array($validate) || !isset($_SERVER['HTTP_REFERER']))
            return $this->response($validate[0] ?? GetLanguage::get('notification_title_error'));

        $delay = $this->commentSystem->findToDelay();
        $ipBan = $this->user->findBanByIp();

        if ($delay)
            return $this->response(GetLanguage::get('wait_5_minutes_for_new_comment'));

        if ($ipBan)
            return $this->response(GetLanguage::get('user_banned_by_ip'));

        $refererExist = $this->model->separateReferer($_SERVER['HTTP_REFERER'], false);

        if (is_array($refererExist) && $refererExist[0] == 'topic') {
            $logicTopicStoreComment = $this->model->prepareStoreComment((int) $refererExist[1]);

            if(is_string($logicTopicStoreComment))
                return $this->response($logicTopicStoreComment);
                
            try {
                $response['topic'] = $logicTopicStoreComment['id'];

                $realCategories = $this->unionCategory->getCategoriesByQuaternary($logicTopicStoreComment['category']);
                if(is_array($realCategories)) {
                    $this->lastActivitiesSystem->store($logicTopicStoreComment['id'], $realCategories);
                }

                $newComment = $this->commentSystem->store($response);
                
                if($newComment) {
                    $this->model->updateBalance($response['topic']);
                    $this->user->updateBalance($_SESSION['userHeavenLogged']['id']);

                    if($_SESSION['userHeavenLogged']['id'] != $logicTopicStoreComment['author']['id']) {
                        $this->notificationSystem->store(
                            $logicTopicStoreComment['author']['id'],
                            sprintf(GetLanguage::get('comment_your_topic'), $logicTopicStoreComment['author']['username']),
                            $this->router->route('Topic.Show', ['id' => $logicTopicStoreComment['id'], 'handle' => $logicTopicStoreComment['url']]),
                            'far fa-comment-alt',
                            $this->notificationCommentIconColors[array_rand($this->notificationCommentIconColors)]
                        );
                    }
                    
                    return $this->response(GetLanguage::get('topic_comment_store_success'), 'success');
                }
            } catch (Exception $e) {}
        }
    }

    public function reaction(Array $data)
    {
        $response = $this->model->shield($data);
        $validate = $this->reactionSystem->validateStore($response);
        
        if(is_array($validate))
            return $this->response($validate[0]);

        if (!$topic = $this->model->find((int) $response['topic'])->execute()) {
            return $this->response(GetLanguage::get('topic_no_exists'));
        } else {
            if ($topic['reactions'] == 'false') {
                return $this->response(GetLanguage::get('topic_reactions_disabled'));
            } else {
                if ($this->reactionSystem->checkReaction($topic['id'])) {
                    return $this->response(GetLanguage::get('already_vote_topic'));
                } else {
                    try {
                        $newVote = $this->reactionSystem->new($response);
                        
                        if ($newVote)
                            return $this->response(GetLanguage::get('vote_successful'), "success");

                        return $this->response("Error");
                    } catch(Exception $e) {}
                }
            }
        }

    }

    public function show()
    {
    }

    public function update()
    {
    }

    public function delete()
    {
    }
}
