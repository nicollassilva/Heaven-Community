<?php

namespace App\Controllers\Apis;

use App\Boot\ForumConfiguration;
use App\Controllers\_interfaces\WebApisControllerInterface;
use App\Core\PHPMailer\HeavenMail;
use App\Core\Utils\BaseApiController;
use App\Languages\GetLanguage;
use App\Models\Apis\User;
use PHPMailer\PHPMailer\Exception;

class UserController extends BaseApiController implements WebApisControllerInterface {
    protected $model;
    protected $router;
    protected $mailSystem;

    function __construct(Object $router)
    {
        $this->model = new User();
        $this->router = $router;
        $this->mailSystem = new HeavenMail;
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
            try{
                $user = trim(strip_tags(htmlspecialchars($response['username'])));
                $email = trim($response['email']);
                
                $this->mailSystem->sendMail(
                    $email,
                    $user,
                    GetLanguage::get('register_text_email_sent'),
                    'registerEmail',
                    [
                        'toName' => $user,
                        'article' => GetLanguage::get('register_text_email_sent'),
                        'urlVerify' => $this->router->route("User.VerifyAccount", ["token" => $newUser])
                    ]
                );
            } catch(Exception $e) {}
            

            return $this->response(GetLanguage::get('registered_success'), "success", "/account/profile");
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
