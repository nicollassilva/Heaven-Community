<?php

    namespace App\Controllers\WebServices;

use App\Core\Utils\BaseApiController;
use App\Models\Apis\TopicUtilities\Comment;
use App\Models\Apis\User;
use App\Models\WebServices\Topic;

class TopicController extends BaseApiController {
    protected $router;
    protected $model;
    protected $user;
    protected $commentSystem;

    function __construct(Object $router)
    {
        $this->router = $router;
        $this->model = new Topic;
        $this->user = new User;
        $this->commentSystem = new Comment;
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
            'topic' => $topic,
            'comments' => $this->commentSystem->findByIdAndPaginate($topic['id'], (isset($data['paginate']) && $data['paginate'] != '1' ? (int) $data['paginate'] - 1 : 0)),
            'page' => (isset($data['paginate']) ? (int) $data['paginate'] : 1),
            'totalComments' => $this->commentSystem->getTotalById($topic['id']),
            'owner' => $this->user->getUserById($topic['author'], ['username', 'avatar', 'url', 'topics', 'comments', 'last_time']),
            'isOwner' => $this->user->isOwner('id', $topic['author'])
        ]);
    }

    public function paginate(Array $data)
    {
        
    }
}