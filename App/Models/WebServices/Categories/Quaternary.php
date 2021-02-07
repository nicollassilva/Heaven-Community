<?php

namespace App\Models\WebServices\Categories;

use App\Core\Utils\BaseApiModel;

class Quaternary extends BaseApiModel {

    function __construct()
    {
        parent::__construct('categories_quaternary', 'id');
    }

    public function show(Int $id)
    {
        $categories = $this
            ->where([
                ['visible', '=', 'true'],
                ['categorie_tertiary_id', '=', $id]
            ])
            ->orderBy('name')
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

    public function findByUrlFather(String $url, Int $father, Bool $always = true)
    {
        $categories = $this->where([
                ['url', '=', strip_tags($url)],
                ['categorie_tertiary_id', '=', $father],
                ['visible', '=', 'true']
            ])->limit(1)
            ->execute();

        return $this->fixArray($categories, $always);
    }
}