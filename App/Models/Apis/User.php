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
        $email = $this->antiSqlInjection(['email' => $email])['email'];
        $username = $this->antiSqlInjection(['username' => $username])['username'];

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
        $newUser = (new User())
            ->request([
                'username' => strip_tags(htmlspecialchars(trim($data['username']))),
                'password' => trim($this->hashFormat($data['password'])),
                'email' => trim(htmlspecialchars($data['email'])),
                'url' => random_int(0, 1000000),
                'register_time' => time(),
                'last_time' => time(),
                'ip_register' => $this->getAdressIP(),
                'token_forgout' => $this->aleatoryToken(30),
                'uuid' => Uuid::uuid1()->toString(),
                'facebook' => strip_tags(htmlspecialchars(trim($data['facebook']))),
                'discord' => strip_tags(htmlspecialchars(trim($data['discord']))),
                'github' => strip_tags(htmlspecialchars(trim($data['github']))),
                'gitlab' => strip_tags(htmlspecialchars(trim($data['gitlab']))),
                'twitter' => strip_tags(htmlspecialchars(trim($data['twitter']))),
            ])->create();

        return $newUser;
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
}