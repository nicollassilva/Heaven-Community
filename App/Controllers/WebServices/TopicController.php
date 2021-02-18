<?php

    namespace App\Controllers\WebServices;

use App\Core\Utils\BaseApiController;
use App\Models\WebServices\Topic;

class TopicController extends BaseApiController {
    protected $router;
    protected $model;

    function __construct(Object $router)
    {
        $this->router = $router;
        $this->model = new Topic;
    }
    
    public function create()
    {
        if(isset($_SERVER) && !isset($_SERVER['HTTP_REFERER']))
            return $this->router->redirect('Web.Index');

        $this->view("topics/create", [
            'referer' => $_SERVER['HTTP_REFERER']
        ]);
    }
}