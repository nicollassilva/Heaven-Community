<?php

namespace App\Models\WebServices;

use App\Core\Utils\BaseApiModel;

class Topic extends BaseApiModel {
    
    function __construct()
    {
        parent::__construct('topics', 'id');
    }

    public function store()
    {
        
    }
}