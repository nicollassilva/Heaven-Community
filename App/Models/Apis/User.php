<?php

namespace App\Models\Apis;

use App\Core\Utils\BaseApiModel;
use App\Languages\GetLanguage;
use App\Models\WebServices\Web;
use Ramsey\Uuid\Nonstandard\Uuid;

class User extends BaseApiModel {
    protected $web;

    function __construct()
    {
        parent::__construct('users', 'id');
        $this->web = new Web;
    }

    public function findRegistered(String $email, String $username): bool
    {
        $email = $this->shield(['email' => $email])['email'];
        $username = $this->shield(['username' => $username])['username'];

        return !!$this
            ->where([['email', '=', $email]])
            ->orWhere([['username', '=', $username]])
            ->count()
            ->execute();
    }

    public function validateStore(Array $filters)
    {
        $validation = \GUMP::is_valid($filters, [
            'username' => 'required|min_len,4|max_len,100|regex,/^([À-üA-Za-z\.:_\-0-9\!\@]+)$/',
            'email' => 'required|valid_email',
            'password' => 'required|min_len,6|max_len,100',
            'confirmPassword' => 'required|equalsfield,password',
            'gender' => 'required|contains,M;F;U',
            'terms' => 'required|contains,Y;N'
        ], [
            'username' => [
                'required' => GetLanguage::get("validation_field_username_required"),
                'min_len' => GetLanguage::get("validation_field_username_minlen"),
                'max_len' => GetLanguage::get("validation_field_username_maxlen"),
                'regex' => GetLanguage::get("validation_field_username_regex")
            ],
            'email' => [
                'required' => GetLanguage::get("validation_field_email_required"),
                'valid_email' => GetLanguage::get("validation_field_email_validate")
            ],
            'password' => [
                'required' => GetLanguage::get("validation_field_password_required"),
                'min_len' => GetLanguage::get("validation_field_password_minlen"),
                'max_len' => GetLanguage::get("validation_field_password_maxlen")
            ],
            'confirmPassword' => [
                'required' => GetLanguage::get("validation_field_confirmPassword_required"),
                'equalsfield' => GetLanguage::get("validation_field_confirmPassword_equalsfield")
            ],
            'gender' => [
                'required' => GetLanguage::get("validation_field_gender_required"),
                'contains' => GetLanguage::get("validation_field_gender_contains")
            ],
            'terms' => [
                'required' => GetLanguage::get("validation_field_terms_required"),
                'contains' => GetLanguage::get("validation_field_terms_contains")
            ]
        ]);

        return $validation;
    }

    public function findBanByIp()
    {
        return !!(new User)
            ->useTable('ip_bans')
            ->where([['ip', '=', $this->getAdressIP()]])
            ->count()
            ->execute();
    }
    
    public function checkLimitAccountByIp()
    {
        $allAccounts = $this
            ->where([['ip_register', '=', $this->getAdressIP()]])
            ->count()
            ->execute();

        return $allAccounts < $this->web->information('max_account_by_id') ? false : true;
    }

    public function register(Array $data)
    {
        $token = $this->aleatoryToken(30);
        $newUser = (new User())
            ->request([
                'username' => strip_tags(htmlspecialchars(trim($data['username']))),
                'password' => trim($this->hashFormat($data['password'])),
                'email' => trim(htmlspecialchars($data['email'])),
                'gender' => trim(htmlspecialchars(strip_tags($data['gender']))),
                'url' => random_int(0, 1000000),
                'register_time' => time(),
                'last_time' => time(),
                'ip_register' => $this->getAdressIP(),
                'ip_last' => $this->getAdressIP(),
                'token_forgout' => $token,
                'uuid' => Uuid::uuid1()->toString(),
                'facebook' => strip_tags(htmlspecialchars(trim($data['facebook']))),
                'discord' => strip_tags(htmlspecialchars(trim($data['discord']))),
                'github' => strip_tags(htmlspecialchars(trim($data['github']))),
                'gitlab' => strip_tags(htmlspecialchars(trim($data['gitlab']))),
                'twitter' => strip_tags(htmlspecialchars(trim($data['twitter']))),
            ])->create();

        return $newUser ? $token : false;
    }

    public function countAllRegistered()
    {
        if (!isset($_SESSION['allRegistered'])) {
            $all = $this
                ->count()
                ->execute();

            $_SESSION['allRegistered'] = $all;
        }

        return $_SESSION['allRegistered'] ?? $all;
    }

    public function validateLogin(Array $filters)
    {
        $validation = \GUMP::is_valid($filters, [
            'username' => 'required|min_len,4|max_len,100|regex,/^([À-üA-Za-z\.:_\-0-9\!\@]+)$/',
            'password' => 'required|min_len,6|max_len,100'
        ], [
            'username' => [
                'required' => GetLanguage::get("validation_field_username_required"),
                'min_len' => GetLanguage::get("validation_field_username_minlen"),
                'max_len' => GetLanguage::get("validation_field_username_maxlen"),
                'regex' => GetLanguage::get("validation_field_username_regex")
            ],
            'password' => [
                'required' => GetLanguage::get("validation_field_password_required"),
                'min_len' => GetLanguage::get("validation_field_password_minlen"),
                'max_len' => GetLanguage::get("validation_field_password_maxlen")
            ]
        ]);

        return $validation;
    }

    public function validateFriendRequestAction(Array $filters)
    {
        $validation = \GUMP::is_valid($filters, [
            'id' => 'required|integer',
            'decision' => 'required|contains,Y;N'
        ], [
            'id' => [
                'required' => GetLanguage::get("validation_field_id_required"),
                'integer' => GetLanguage::get("validation_field_id_integer")
            ],
            'decision' => [
                'required' => GetLanguage::get("validation_field_password_required"),
                'contains' => GetLanguage::get("validation_field_decision_contains")
            ]
        ]);

        return $validation;
    }

    public function getUserByUsername(String $username)
    {
        return $this
            ->where([['username', '=', $username]])
            ->except(['token_forgout'])
            ->limit(1)
            ->execute();
    }

    public function updateLogin(Int $id)
    {
        $user = (new User)->find($id)->execute(true);
        if($user) {
            $user->last_time = time();
            $user->ip_last = $this->getAdressIP();
            $user->save();
        }

        return $this;
    }

    public function userLogged()
    {
        $uuidCookie = isset($_COOKIE['heaven_user_cookie_uuid']) ? $_COOKIE['heaven_user_cookie_uuid'] : null;
        $uuidSession = isset($_SESSION['user_uuid']) ? $_SESSION['user_uuid'] : null;

        if ($uuidSession !== null) {
            $user = $this->where([
                ['uuid', '=', $uuidSession],
                ['ip_last', '=', $this->getAdressIP()]
            ])->limit(1)->except(['password'])->execute();

            if (is_array($user)) {
                unset($_SESSION['user_uuid']);
                $_SESSION['userHeavenLogged'] = $user;

                return true;
            }
        } else {
            if (isset($_SESSION['userHeavenLogged'])) {
                return true;
            } else {
                if ($uuidCookie !== null) {
                    $user = $this->where([
                        ['uuid', '=', strip_tags(trim(htmlspecialchars($uuidCookie)))],
                        ['ip_last', '=', $this->getAdressIP()]
                    ])->except(['password'])->limit(1)->execute();
                    if (is_array($user)) {
                        unset($_SESSION['user_uuid']);
                        $_SESSION['userHeavenLogged'] = $user;
                        
                        return true;
                    } else {
                        if(isset($_COOKIE['pixelfeed_user_uuid']))
                            setcookie('pixelfeed_user_uuid', null, -1, "/");
                            
                        session_destroy();
                        return false;
                    }
                } else {
                    if(isset($_COOKIE['pixelfeed_user_uuid']))
                        setcookie('pixelfeed_user_uuid', null, -1, "/");

                    unset($_SESSION['user_uuid']);
                    unset($_SESSION['userHeavenLogged']);
                    return false;
                }
            }
        }
    }

    public function realGender(String $gender)
    {
        switch ($gender) {
            case 'M':
                return [ 'text' => GetLanguage::get('register_text_gender_male'), 'icon' => 'fas fa-mars', 'color' => '#29AAE3'];
                break;
            case 'F':
                return [ 'text' => GetLanguage::get('register_text_choise_female'), 'icon' => 'fas fa-venus', 'color' => '#FEA6D6' ];
                break;
            case 'U':
                return [ 'text' => GetLanguage::get('register_text_choise_undefined'), 'icon' => 'fas fa-neuter', 'color' => '#212121' ];
                break;
            default:
                return [ 'text' => GetLanguage::get('register_text_gender_male'), 'icon' => 'fas fa-mars', 'color' => '#29AAE3'];
                break;
        }
    }

    public function realSocial(?String $social)
    {
        return null !== $social ? @preg_replace("/^(https:\/\/|http:\/\/)?(www.)?(.*(\.com\/|\.app\/|\.com\.br\/|\.org\/))/", "", $social) : null;
    }

    public function getUserById(Int $id, Array $data)
    {
        return $this
            ->find($id)
            ->only($data)
            ->limit(1)
            ->execute();
    }
}