<?php

namespace App\Models\WebServices;

use App\Core\Utils\BaseApiModel;

class Web extends BaseApiModel {
    
    function __construct()
    {
        parent::__construct('heaven_config', 'id');
    }

    public function information(String $information)
    {
        $info = $this
            ->find(1)
            ->only([$information])
            ->execute();

        return isset($info[$information]) ? $info[$information] : false;
    }
}