<?php

namespace App\Models\WebServices\Categories;

use App\Core\Utils\BaseApiModel;

class Secondary extends BaseApiModel {

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

    public function findByUrl(String $url, Bool $always = true)
    {
        $categories = $this->where([
                ['url', '=', strip_tags($url)],
                ['visible', '=', 'true']
            ])->limit(1)
            ->execute();

        return $this->fixArray($categories, $always);
    }
}