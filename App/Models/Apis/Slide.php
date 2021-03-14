<?php

namespace App\Models\Apis;

use App\Core\Utils\BaseApiModel;

class Slide extends BaseApiModel {

    function __construct()
    {
        parent::__construct('heaven_slides', 'id');
    }
}