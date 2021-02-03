<?php

namespace App\Core\Utils;

trait CsrfTrait {
    public function CsrfIsValid(String $token = '')
    {
        if(empty($token) || empty($_SESSION['_token']))
            return false;

        return !!hash_equals($token, $_SESSION['_token']);
    }
}
