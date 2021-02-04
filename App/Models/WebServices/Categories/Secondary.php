<?php

namespace App\Models\WebServices\Categories;

use App\Core\Utils\BaseApiModel;

class Secondary extends BaseApiModel {
    protected $table = 'categories_secondary';

    function __construct()
    {
        parent::__construct('categories_secondary', 'id');
    }

    public function show(Int $id)
    {
        $categories = $this
            ->where([
                ['visible', '=', 'true'],
                ['categorie_primary_id', '=', $id]
            ])
            ->orderBy('sequence')
            ->execute();

        return $this->fixArray($categories);
    }
}