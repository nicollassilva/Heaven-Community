<?php

namespace App\Models\Apis\UserUtilities;

use App\Core\Utils\BaseApiModel;

class Activitie extends BaseApiModel {

    function __construct()
    {
        parent::__construct('users_activities', 'id');
    }

    public function store(Int $id, String $text)
    {
        (new Activitie)
            ->request([
                'user_id' => $id,
                'text' => htmlspecialchars(trim($text)),
                'date' => time()
            ])->create();
    }

    public function getActivities(Int $id, Int $limit = 20)
    {
        return $this->
            fixArray(
                $this->where([['user_id', '=', $id]])->limit($limit)->orderBy('id', 'DESC')->execute()
            );
    }
}