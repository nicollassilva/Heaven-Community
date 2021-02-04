<?php

namespace App\Models\WebServices\Categories;

use App\Core\Utils\BaseApiModel;

class Primary extends BaseApiModel {

    function __construct()
    {
        parent::__construct('categories_primary', 'id');
    }

    public function show()
    {
        $categories = $this
            ->where([['visible', '=', 'true']])
            ->orderBy('sequence')
            ->execute();

        return $this->fixArray($categories);
    }
}