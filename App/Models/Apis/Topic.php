<?php

namespace App\Models\Apis;

use App\Models\Apis\User;
use App\Languages\GetLanguage;
use App\Core\Utils\BaseApiModel;
use App\Models\Apis\TopicUtilities\LastActivities;

class Topic extends BaseApiModel {
    protected $lastActivitiesSystem;
    protected $userSystem;

    function __construct()
    {
        parent::__construct('topics', 'id');
        $this->lastActivitiesSystem = new LastActivities;
        $this->userSystem = new User;
    }

    public function validateStore(Array $filters)
    {
        $validation = \GUMP::is_valid($filters, [
            'title' => 'required|min_len,6|max_len,255',
            'text' => 'required|min_len,30|max_len,5000',
            'comments' => 'required|contains,Y;N',
            'reactions' => 'required|contains,Y;N',
            'type' => 'required|contains,C;R;CMS;A;P',
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
                'type' => $data['type'] === 'C' ? 'normal' : ($data['type'] === 'R' ? 'request' : ($data['type'] === 'CMS' ? 'cms' : ($data['type'] == 'P' ? 'pack' : 'help'))),
                'comments' => $data['comments'] === 'Y' ? 'true' : 'false',
                'reactions' => $data['reactions'] === 'Y' ? 'true' : 'false',
                'date' => time()
            ])->create();
    }

    public function separateReferer(String $routerReferer, Bool $paramInt = true)
    {
        $routerReferer = explode('/', $routerReferer);
        
        if(is_array($routerReferer) && count($routerReferer) >= 5)
            return [
                !isset($routerReferer[5]) ? htmlspecialchars(trim(strip_tags($routerReferer[3]))) : ($paramInt ? (int) $routerReferer[3] : $routerReferer[3]),
                htmlspecialchars(trim(strip_tags($routerReferer[4]))),
                isset($routerReferer[5]) ? htmlspecialchars(trim(strip_tags($routerReferer[5]))) : null
            ];

        return false;
    }
    
    public function countAllTopics()
    {
        if (!isset($_SESSION['allTopics'])) {
            $all = $this
                ->where([['visible', '=', 'true']])
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

    public function prepareStoreComment(Int $topic)
    {
        $topic = $this->find($topic)->execute();

        if(!$topic)
            return GetLanguage::get('topic_no_exists');

        if($topic['comments'] == 'false' || $topic['visible'] == 'false' || $topic['moderate'] == 'closed')
            return GetLanguage::get('topic_comments_disabled');

        return [
            'id' => (int) $topic['id'],
            'category' => (int) $topic['category'],
            'author' => (new User)->find($topic['author'])->only(['username', 'id'])->execute(),
            'url' => $topic['url']
        ];
    }

    public function lastTopic(Int $categorieId, String $categorie = 'secondary')
    {
        $categorie = 'categorie_' . $categorie . '_id';

        return $this->lastActivitiesSystem->show($categorieId, $categorie);
    }

    public function updateBalance(Int $topic, String $balance = 'comments')
    {
        $topic = $this->find($topic)->execute(true);

        if(!$topic)
            return false;

        $balance == 'comments' ? $topic->commentsT++ : $topic->views++;
        $topic->save();
    }
}