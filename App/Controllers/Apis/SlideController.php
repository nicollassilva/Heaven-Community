<?php

namespace App\Controllers\Apis;

use App\Core\Utils\BaseApiController;
use App\Models\Apis\Slide;

class SlideController extends BaseApiController
{
    protected $model;

    function __construct(?Object $router = null)
    {
        $this->model = new Slide;
    }
    public function show($limit = 6)
    {
        return $this->model
            ->fixArray(
                $this->model->orderBy('id', 'DESC')->limit($limit)->execute()
            );
    }
}