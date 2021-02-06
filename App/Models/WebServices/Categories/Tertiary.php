<?php

namespace App\Models\WebServices\Categories;

use App\Core\Utils\BaseApiModel;

class Tertiary extends BaseApiModel {

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

    public function findByUrl(String $url)
    {
        $categories = $this->where([
                ['url', '=', strip_tags($url)],
                ['visible', '=', 'true']
            ])->limit(1)
            ->execute();

        return $this->fixArray($categories);
    }

    public function findByFather(Int $father)
    {
        $categories = $this->where([
                ['categorie_secondary_id', '=', $father],
                ['visible', '=', 'true']
            ])->execute();

        return $this->fixArray($categories);
    }
}