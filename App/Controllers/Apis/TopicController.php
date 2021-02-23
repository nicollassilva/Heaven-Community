<?php

namespace App\Controllers\Apis;

use App\Controllers\_interfaces\WebApisControllerInterface;
use App\Core\Utils\BaseApiController;
use App\Languages\GetLanguage;
use App\Models\Apis\Topic;
use App\Models\Apis\User;
use App\Models\WebServices\Categories\Union;
use Exception;

class TopicController extends BaseApiController implements WebApisControllerInterface {
    protected $router;
    protected $model;
    protected $unionCategory;


    function __construct(Object $router)
    {
        $this->router = $router;
        $this->model = new Topic;
        $this->user = new User;
        $this->unionCategory = new Union;
    }

    public function store(Array $data)
    {
        $response = $this->model->shield($data);
        $validation = $this->model->validateStore($response);

        if(is_array($validation))
            return $this->response($validation[0]);

        $delay = $this->model->findToDelay();
        $ipBan = $this->user->findBanByIp();

        if($delay)
            return $this->response(GetLanguage::get('wait_5_minutes_for_new_topic'));

        if($ipBan)
            return $this->response(GetLanguage::get('user_banned_by_ip'));

        $refererExist = $this->model->separateReferer($response['referer']);

        if(!$refererExist)
            return $this->response(GetLanguage::get('new_topic_store_error'));

        $category = $this->unionCategory
            ->logicUrl(...$refererExist);

        if(!$category)
            return $this->response(GetLanguage::get('new_topic_invalid_referer_url'));

        $response['categoryId'] = isset($category['quaternary']['id']) ? $category['quaternary']['id'] : (isset($category['tertiary']['id']) ? $category['tertiary']['id'] : null);

        try {
            $newTopic = $this->model->new($response);

            if($newTopic)
                return $this->response(
                    GetLanguage::get('new_topic_store_success'), 
                    "success"
                );

            return $this->response(GetLanguage::get('new_topic_store_error'));
        } catch (Exception $error) {
            return $this
                ->response(GetLanguage::get('new_topic_store_error'));
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