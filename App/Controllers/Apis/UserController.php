<?php

namespace App\Controllers\Apis;

use App\Controllers\_interfaces\WebApisControllerInterface;
use App\Core\Utils\BaseApiController;
use App\Languages\GetLanguage;
use App\Models\Apis\User;

class UserController extends BaseApiController implements WebApisControllerInterface {
    protected $model;
    protected $router;

    function __construct(Object $router)
    {
        $this->model = new User();
        $this->router = $router;
    }

    public function store(Array $data)
    {
        $response = $this->model->antiSqlInjection($data);
        $validate = $this->model->validateStore($response);
            if(is_array($validate)) return $this->response($validate[0]);

        $dataRegistered = $this->model->findRegistered($response['email'], $response['username']);
        $ipBan = $this->model->findBanByIp();
        $limitAccount = $this->model->checkLimitAccountByIp();

        if($dataRegistered)
            return $this->response(GetLanguage::get('user_already_registered'));

        if($ipBan)
            return $this->response(GetLanguage::get('user_banned_by_ip'));

        if($limitAccount)
            return $this->response(GetLanguage::get('register_max_account_by_ip'));

        $newUser = $this->model->register($response);

        if($newUser) {
            return $this->response(GetLanguage::get('registered_success'), "success", "/me/profile");
        } else {
            return $this->response("Error Code R01");
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
