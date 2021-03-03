<?php

namespace App\Models\Apis\TopicUtilities;

use App\Core\Utils\BaseApiModel;

class Comment extends BaseApiModel {

    function __construct()
    {
        parent::__construct('topics_comments', 'id');
    }

    public function store(Array $data)
    {
        (new Comment)
            ->request([
                'topic' => trim(strip_tags($data['topic'])),
                'author' => $_SESSION['userHeavenLogged']['id'],
                'text' => $data['text'],
                'ip' => $this->getAdressIP(),
                'date' => time()
            ])->create();
    }

    public function validateStore(Array $filters)
    {
        $validation = \GUMP::is_valid($filters, [
            'text' => 'required|min_len,6|max_len,5000'
        ], [
            'text' => [
                'required' => 'Digite seu comentário',
                'min_len' => 'O comentário precisa ter mais de 6 caracteres',
                'max_len' => 'O comentário pode ter no máximo 5000 caracteres'
            ]
        ]);

        return $validation;
    }

    public function getComments(Int $id, Int $limit = 20)
    {
        return $this->
            fixArray(
                $this->where([['author', '=', $id]])->limit($limit)->orderBy('id', 'DESC')->execute()
            );
    }

    public function findToDelay()
    {
        return $this->where([
                ['author', '=', $_SESSION['userHeavenLogged']['id']],
                ['date', '>', (time() - 5 * 60)]
            ])->limit(1)
            ->orderBy('id', 'DESC')
            ->count()
            ->execute();
    }

    public function findByIdAndPaginate(Int $topic, Int $paginate, Int $limit = 15)
    {
        return $this->
            fixArray(
                (new Comment)
                    ->useTable('users u, topics_comments c')
                    ->where([
                        ['c.topic', '=', $topic],
                        ['c.visible', '=', 'true'],
                        ['u.id', '=', 'c.author', false]
                    ])->only(['c.*', 'u.username', 'u.avatar', 'u.url'])
                    ->take($limit)
                    ->skip($paginate)
                    ->orderBy('id', 'DESC')
                    ->execute()
            );
    }
    
    public function getTotalById(Int $topic)
    {
        return $this->where([['topic', '=', $topic], ['visible', '=', 'true']])->count()->execute();
    }
}