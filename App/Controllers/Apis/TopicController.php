<?php

namespace App\Controllers\Apis;

use App\Controllers\_interfaces\WebApisControllerInterface;
use App\Core\Utils\BaseApiController;
use App\Languages\GetLanguage;
use App\Models\Apis\Balance;
use App\Models\Apis\Topic;
use App\Models\Apis\User;
use App\Models\WebServices\Categories\Union;
use App\Models\Apis\TopicUtilities\Comment;
use App\Models\Apis\TopicUtilities\LastActivities;
use Exception;

class TopicController extends BaseApiController implements WebApisControllerInterface
{
    protected $router;
    protected $model;
    protected $unionCategory;
    protected $commentSystem;
    protected $lastActivitiesSystem;


    function __construct(Object $router)
    {
        $this->router = $router;
        $this->model = new Topic;
        $this->user = new User;
        $this->unionCategory = new Union;
        $this->commentSystem = new Comment;
        $this->lastActivitiesSystem = new LastActivities;
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
                $this->lastActivitiesSystem->store($lastTopic['id']);
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
                $response['topic'] = $logicTopicStoreComment;
                $newComment = $this->commentSystem->store($response);
                
                if($newComment)
                    return $this->response(GetLanguage::get('topic_comment_store_success'), 'success');
            } catch (Exception $e) {}
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
