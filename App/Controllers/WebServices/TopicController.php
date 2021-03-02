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

    public function show(Array $data)
    {
        if(!isset($data['id']) || !is_numeric($data['id']) || !isset($data['handle']))
            return $this->view('error');

        $id = (int) $data['id'];
        $handle = ($this->model->shield($data))['handle'];

        if((!$topic = $this->model->find($id)->limit(1)->execute()) || $handle != $topic['url'])
            return $this->view('error');

        return $this->view("topics/show", [
            'topic' => $topic
        ]);
    }

    public function paginate(Array $data)
    {
        
    }
}