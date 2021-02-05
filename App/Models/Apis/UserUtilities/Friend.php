<?php

namespace App\Models\Apis\UserUtilities;

use App\Core\Utils\BaseApiModel;

class Friend extends BaseApiModel {

    function __construct()
    {
        parent::__construct('users_friends', 'id');
    }

    public function store(Int $id, Int $id2)
    {
        (new Activitie)
            ->request([
                'user_one' => $id,
                'user_two' => $id2,
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