<?php

namespace App\Models\WebServices\Categories;

use App\Core\Utils\BaseApiModel;
use SimplePHP\Model\SimplePHP;

class Secondary extends SimplePHP {
    protected $table = 'categories_secondary',
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
                ['categorie_primary_id', '=', $id]
            ])
            ->orderBy('sequence')
            ->execute();

        return $this->fixArray($categories);
    }
}