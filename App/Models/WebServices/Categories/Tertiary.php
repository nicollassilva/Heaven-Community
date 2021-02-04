<?php

namespace App\Models\WebServices\Categories;

use App\Core\Utils\BaseApiModel;

class Tertiary extends BaseApiModel {
    protected $table = 'categories_tertiary';

    function __construct()
    {
        parent::__construct('categories_tertiary', 'id');
    }

    public function show(Int $id)
    {
        $categories = $this
            ->where([
                ['visible', '=', 'true'],
                ['categorie_secondary_id', '=', $id]
            ])
            ->orderBy('name')
            ->execute();

        return $this->fixArray($categories);
    }
}