<?php

namespace App\Models\Apis\TopicUtilities;

use App\Core\Utils\BaseApiModel;

class Reactions extends BaseApiModel {

    function __construct()
    {
        parent::__construct('topics_reactions', 'id');
    }

    public function showById(Int $topic)
    {
        $reactions = $this
            ->fixArray(
                $this->where([
                    ['topic', '=', $topic]
                ])->only(['COUNT(id) as count', 'type'])
                ->groupBy('type')->execute()
            );

        if(is_array($reactions)) {
            $realReactions = [];
            foreach($reactions as $react)
                $realReactions[$react['type']] = $react['count'];
        }

        return $realReactions ?? null;
    }

    public function checkReaction(Int $topic)
    {
        return $this->where([
            ['author', '=', $_SESSION['userHeavenLogged']['id']],
            ['topic', '=', $topic]
        ])
        ->count()
        ->execute();
    }

    public function new(Array $data)
    {
        return (new Reactions)
            ->request([
                'topic' => (int) $data['topic'],
                'author' => $_SESSION['userHeavenLogged']['id'],
                'type' => trim(htmlspecialchars(strip_tags($data['type']))),
                'date' => time()
            ])->create();
    }

    public function validateStore(Array $filters)
    {
        $is_valid = \GUMP::is_valid($filters, [
            'type' => 'required|contains,like;love;unlike',
            'topic' => 'required|numeric'
        ], [
            'type' => [
                'required' => 'O tipo de reação é obrigatório',
                'contains' => 'Valor para tipo de reação indisponível',
            ],
            'topic' => [
                'required' => 'ID do tópico não foi encontrado',
                'numeric' => 'O tópico precisa ser um valor numérico',
            ]
        ]);

        return $is_valid;
    }
}