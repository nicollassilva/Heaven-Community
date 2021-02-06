<?php

namespace App\Models\Apis\UserUtilities;

use App\Core\Utils\BaseApiModel;
use App\Models\Apis\User;

class Friend extends BaseApiModel {
    protected $user;

    function __construct()
    {
        parent::__construct('users_friends', 'id');
        $this->user = new User;
    }

    public function store(Int $id, Int $id2)
    {
        (new Friend)
            ->request([
                'user_one' => $id,
                'user_two' => $id2,
                'date' => time()
            ])->create();
    }

    public function findAndUpdate(Int $id, String $decision)
    {
        $friendRequest = (new Friend)
            ->whereRaw("id = '${id}' AND status = 'pending'")
            ->limit(1)
            ->execute(true);
        
        if(is_object($friendRequest)) {
            $userName = $this->user->find($friendRequest->user_one)->only(['username', 'id', 'url'])->execute();
            $friendRequest->status = $decision === 'Y' ? 'accepted' : 'declined';
            $friendRequest->save();

            return $userName ?? true;
        } else {
            return false;
        }
    }

    public function getFriendlist(Int $id, Int $limit = 20, String $status)
    {
        $friends = $this->
            fixArray(
                $this
                ->where([['user_two', '=', $id], ['status', '=', $status]])
                ->limit($limit)
                ->orderBy('id', 'DESC')
                ->execute()
            );

        $allFriends = [];

        if(is_array($friends)) {
            foreach($friends as $friend) {
                $friend['data'] = $this->user->getUserById(
                    ($friend['user_one'] != $id ? $friend['user_one'] : $friend['user_two']),
                    ['id', 'url', 'last_time', 'avatar', 'username']
                );

                $allFriends[] = $friend;
            }
        }

        return $allFriends ?? null;
    }
}