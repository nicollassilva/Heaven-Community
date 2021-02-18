<?php

namespace App\Controllers\Apis;

use App\Controllers\_interfaces\WebApisControllerInterface;
use App\Core\Utils\BaseApiController;
use App\Languages\GetLanguage;
use App\Models\Apis\Topic;
use App\Models\Apis\User;

class TopicController extends BaseApiController implements WebApisControllerInterface {
    protected $router;
    protected $model;


    function __construct(Object $router)
    {
        $this->router = $router;
        $this->model = new Topic;
        $this->user = new User;
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