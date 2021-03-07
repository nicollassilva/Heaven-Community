<?php

namespace App\Models\Apis\TopicUtilities;

use App\Core\Utils\BaseApiModel;

class LastActivities extends BaseApiModel {
    /** @var int */
    public $limitShow = 15;
    
    function __construct()
    {
        parent::__construct('last_activities', 'id');
    }

    /**
     * @param int $topic
     * @return bool
     */
    public function store(Int $topic, Array $categories)
    {
        if(!$this->checkEqualsActivitie($topic)) {
            (new LastActivities)
            ->request([
                'topic' => $topic,
                'categorie_secondary_id' => $categories['secondary'],
                'categorie_tertiary_id' => $categories['tertiary'],
                'categorie_quaternary_id' => $categories['quaternary'],
                'author' => $_SESSION['userHeavenLogged']['id'],
                'date' => time()
            ])->create();
        }
    }

    /**
     * @return null|array|false
     */
    public function show()
    {
        $lastActivities = (new LastActivities)
            ->useTable('last_activities la, users u, topics t')
            ->where([
                ['la.topic', '=', 't.id', false],
                ['la.author', '=', 'u.id', false],
                ['t.visible', '=', 'true']
            ])
            ->only(['t.id as idTopic', 'la.id', 't.type', 't.title', 't.url', 'la.date', 'u.username', 'u.avatar', 'u.url as urlProfile'])
            ->limit(15)
            ->orderBy('la.id', 'DESC')
            ->execute();
        
        return $this->fixArray($lastActivities);
    }

    public function checkEqualsActivitie(Int $idTopic)
    {
        $lasts = $this
            ->fixArray(
                $this->orderBy('id', 'DESC')->only(['topic'])->limit($this->limitShow)->execute()
            );
        if (is_array($lasts)) {
            foreach($lasts as $last) {
                if($last['topic'] == $idTopic) {
                    $latest =(new LastActivities)->where([['topic', '=', $idTopic]])->limit(1)->orderBy('id', 'DESC')->execute(true);
                    $latest->destroy();
                }
            }
        }
        return false;
    }
}