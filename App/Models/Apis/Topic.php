<?php

namespace App\Models\Apis;

use App\Core\Utils\BaseApiModel;

class Topic extends BaseApiModel {

    function __construct()
    {
        parent::__construct('topics', 'id');
    }
}