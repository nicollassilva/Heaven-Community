<?php

namespace App\Models\Apis;

use App\Core\Utils\BaseApiModel;

class Topic extends BaseApiModel {

    function __construct()
    {
        parent::__construct('topics', 'id');
    }

    public function validateStore(Array $filters)
    {
        $validation = \GUMP::is_valid($filters, [
            'title' => 'required|min_len,6|max_len,255',
            'text' => 'required|min_len,30|max_len,5000',
            'comments' => 'required|contains,Y;N',
            'reactions' => 'required|contains,Y;N',
            'type' => 'required|contains,C;R;CMS;A',
            'referer' => 'required|valid_url'
        ], [
            'title' => [
                'required' => 'O campo título é obrigatório',
                'min_len' => 'Digite no mínimo 6 caracteres no título',
                'max_len' => 'Digite no máximo 255 caracteres no título'
            ],
            'text' => [
                'required' => 'Digite seu tópico',
                'min_len' => 'O tópico deve conter no mínimo 30 caracteres',
                'max_len' => 'O tópico pode ter no máximo 5000 caracteres'
            ],
            'comments' => [
                'required' => 'Preencha se deseja habilitar os comentários nos tópicos',
                'contains' => 'Valor inválido para comentários'
            ],
            'reactions' => [
                'required' => 'Preencha se deseja habilitar as reações nos tópicos',
                'contains' => 'Valor inválido para reações'
            ],
            'type' => [
                'required' => 'Preencha o tipo do seu tópico',
                'contains' => 'Valor inválido para tipo de tópico'
            ],
            'referer' => [
                'required' => 'Entre em uma categoria para postar um novo tópico',
                'valid_url' => 'Você está tentando postar um tópico em uma categoria inválida'
            ]
        ]);

        return $validation;
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

    public function new(Array $data)
    {
        if(!$data['categoryId'])
            return false;

        return $this->
            request([
                'title' => strip_tags($data['title']),
                'text' => $data['text'],
                'author' => $_SESSION['userHeavenLogged']['id'],
                'url' => $this->urlFormat(strip_tags($data['title'])),
                'category' => $data['categoryId'],
                'type' => $data['type'] === 'C' ? 'normal' : ($data['type'] === 'R' ? 'request' : ($data['type'] === 'CMS' ? 'cms' : 'help')),
                'comments' => $data['comments'] === 'Y' ? 'true' : 'false',
                'reactions' => $data['reactions'] === 'Y' ? 'true' : 'false',
                'date' => time()
            ])->create();
    }

    public function separateReferer(String $routerReferer)
    {
        $routerReferer = explode('/', $routerReferer);
        
        if(is_array($routerReferer) && count($routerReferer) >= 5)
            return [
                !isset($routerReferer[5]) ? htmlspecialchars(trim(strip_tags($routerReferer[3]))) : (int) $routerReferer[3],
                htmlspecialchars(trim(strip_tags($routerReferer[4]))),
                isset($routerReferer[5]) ? htmlspecialchars(trim(strip_tags($routerReferer[5]))) : null
            ];

        return false;
    }
    
    public function countAllTopics()
    {
        if (!isset($_SESSION['allTopics'])) {
            $all = $this
                ->count()
                ->execute();

            $_SESSION['allTopics'] = $all;
        }

        return $_SESSION['allTopics'] ?? $all;
    }
    
    public function byCategorie(Int $categorie, Int $limit = 15)
    {
        return $this->fixArray(
            (new Topic)->useTable('topics t, users u')->where([
                ['t.category', '=', $categorie],
                ['u.id', '=', 't.author', false]
            ])
            ->only(['t.*', 'u.username', 'u.url as urlProfile'])
            ->limit($limit)
            ->orderBy('id', 'DESC')
            ->execute()
        );
    }
}