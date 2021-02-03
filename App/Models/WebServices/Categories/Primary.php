<?php

namespace App\Models\WebServices\Categories;

use App\Core\Utils\BaseApiModel;
use SimplePHP\Model\SimplePHP;

class Primary extends SimplePHP {
    protected $table = 'categories_primary',
              $core;

    function __construct()
    {
        parent::__construct();
        $this->core = new BaseApiModel;
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