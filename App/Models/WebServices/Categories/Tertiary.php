<?php

namespace App\Models\WebServices\Categories;

use App\Core\Utils\BaseApiModel;
use SimplePHP\Model\SimplePHP;

class Tertiary extends SimplePHP {
    protected $table = 'categories_tertiary',
              $core;

    function __construct()
    {
        parent::__construct();
        $this->core = new BaseApiModel;
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