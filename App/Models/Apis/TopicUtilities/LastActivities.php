<?php

namespace App\Models\Apis\TopicUtilities;

use App\Core\Utils\BaseApiModel;

class LastActivities extends BaseApiModel {

    function __construct()
    {
        parent::__construct('last_activities', 'id');
    }

    public function store(Int $topic)
    {
        return (new LastActivities)
            ->request([
                'topic' => $topic,
                'author' => $_SESSION['userHeavenLogged']['id'],
                'date' => time()
            ])->create();
    }

    public function show()
    {
        $lastActivities = (new LastActivities)
            ->useTable('last_activities la, users u, topics t')
            ->where([
                ['la.topic', '=', 't.id', false],
                ['la.author', '=', 'u.id', false],
                ['t.visible', '=', 'true']
            ])
            ->only(['t.id as idTopic', 'la.id', 't.title', 't.url', 'la.date', 'u.username', 'u.avatar', 'u.url as urlProfile'])
            ->groupBy('topic')
            ->limit(15)
            ->orderBy('date', 'DESC')
            ->execute();
        
        return $this->fixArray($lastActivities);
    }
}