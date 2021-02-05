<?php

namespace App\Controllers\Apis;

use App\Controllers\_interfaces\WebApisControllerInterface;
use App\Core\PHPMailer\HeavenMail;
use App\Core\Utils\BaseApiController;
use App\Languages\GetLanguage;
use App\Models\Apis\UserUtilities\Activitie;
use App\Models\Apis\UserUtilities\Notification;
use App\Models\Apis\User;
use PHPMailer\PHPMailer\Exception;

class UserController extends BaseApiController implements WebApisControllerInterface {

    /** @var object */
    protected $model;

    /** @var object */
    protected $router;

    /** @var object */
    protected $mailSystem;

    /** @var object */
    protected $notificationSystem;

    /** @var object */
    protected $activitieSystem;

    /**
     * @param object $router
     * @return void
     */
    function __construct(Object $router)
    {
        $this->model = new User();
        $this->router = $router;
        $this->mailSystem = new HeavenMail;
        $this->notificationSystem = new Notification;
        $this->activitieSystem = new Activitie;
    }

    /**
     * @param array $data
     * @return string
     */
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

        if($data['terms'] === 'N')
            return $this->response(GetLanguage::get('register_text_not_accept_terms'));

        $newUser = $this->model->register($response);

        if($newUser) {
            try{
                $user = trim(strip_tags(htmlspecialchars($response['username'])));
                $email = trim($response['email']);
                $getUserId = (new User)->where([['username', '=', $user]])->only(['id'])->execute();

                if(is_array($getUserId)) {
                    $this->notificationSystem->store(
                        (int) $getUserId['id'], 
                        GetLanguage::get('welcome_message_after_register'), 
                        $this->router->route("Web.Rules"), 
                        'far fa-hand-peace', 
                        '#10ac84'
                    );

                    $this->activitieSystem->store(
                        (int) $getUserId['id'], 
                        GetLanguage::get('registered_success') . ' ' . GetLanguage::get('register_text_email_sent')
                    );
                }

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

    /**
     * @param array $data
     * @return string
     */
    public function login(Array $data)
    {
        $response = $this->model->antiSqlInjection($data);
        $validate = $this->model->validateLogin($response);
            if(is_array($validate)) return $this->response($validate[0]);

        $ipBan = $this->model->findBanByIp();
        
        if($ipBan)
            return $this->response(GetLanguage::get('user_banned_by_ip'));

        $username = trim(htmlspecialchars(strip_tags($response['username'])));
        $user = $this->model->getUserByUsername($username);

        if(!is_array($user))
            return $this->response(GetLanguage::get('login_account_no_exists'));

        if(!password_verify($response['password'], $user['password'])) {
            return $this->response(GetLanguage::get('incorrect_password'));
        } else {
            $_SESSION['user_uuid'] = $user['uuid'];
            $this->model->updateLogin($user['id']);

            if(isset($response['autoLogin']) && $response['autoLogin'] == 'on') {
                setcookie('heaven_user_cookie_uuid', $user['uuid'], time() + 604800, "/");
            }

            return $this->response(GetLanguage::get('login_text_welcome_back'), "success", "/");
        }
    }

    public function logout()
    {
        if(isset($_SESSION['userHeavenLogged'])) {
            unset($_SESSION['userHeavenLogged']);
            unset($_SESSION['myNotifications']);
            setcookie("heaven_user_cookie_uuid", null, -1, "/");

            return $this->response(GetLanguage::get('come_back_again'), "success");
        }

        return $this->response("Error!");
    }

    public function profile(Array $data)
    {
        if(is_numeric($data['handle'])) {
            $url = (int) $data['handle'];
            if(isset($_SESSION['userHeavenLogged']) && $url === $_SESSION['userHeavenLogged']['url']) {
                $user = $_SESSION['userHeavenLogged'];
            } else {
                $user = $this->model->where([['url', '=', $url]])->limit(1)->except(['password', 'token_forgout', 'uuid'])->execute();
            }
            $userActivities = $this->activitieSystem->getActivities($user['id']);

            return $this->view('users/profile', [
                    'user' => $user,
                    'isOwner' => isset($_SESSION['userHeavenLogged']) && $user['id'] === $_SESSION['userHeavenLogged']['id'],
                    'gender' => $this->model->realGender($user['gender']),
                    'social' => function(?String $social) {
                        return $this->model->realSocial($social);
                    },
                    'activities' => $userActivities
                ]);
        } else {
            return $this
                ->view('error');
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
