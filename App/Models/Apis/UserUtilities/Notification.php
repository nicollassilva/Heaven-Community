<?php

namespace App\Models\Apis\UserUtilities;

use App\Boot\ForumConfiguration;
use App\Core\Utils\BaseApiModel;
use Exception;

class Notification extends BaseApiModel {

    function __construct()
    {
        parent::__construct('users_notifications', 'id');
    }

    public function getNotifications(Bool $ignoreTime = false)
    {
        if (isset($_SESSION['userHeavenLogged']) && isset($_SESSION['userHeavenLogged']['id'])) {
            if(!isset($_SESSION['myNotifications'])) {
                $notifications = $this->takeMyNotifications();

                $_SESSION['myNotifications'] = ['time' => time(), 'n' => $notifications, 'c' => is_array($notifications) ? count($notifications) : 0];
                return $notifications;
            } else {
                if(!$ignoreTime && $_SESSION['myNotifications']['time'] > (time() - 1 * 60)) {
                    return $_SESSION['myNotifications']['n'];
                } else {
                    $notifications = $this->takeMyNotifications();

                    $_SESSION['myNotifications'] = ['time' => time(), 'n' => $notifications, 'c' => is_array($notifications) ? count($notifications) : 0];
                    return $notifications;
                }
            }
        } else {
            return false;
        }
    }

    public function takeMyNotifications()
    {
        $notifications = $this
            ->where([
                ['user_id', '=', $_SESSION['userHeavenLogged']['id']],
                ['viewed', '=', 'false']
            ])
            ->orderBy('id', 'DESC')
            ->limit(20)
            ->execute();

        return $this->fixArray($notifications);
    }

    public function store(Int $id, String $text, String $url = '', String $icon = '', String $iconColor = '')
    {
        try {
            (new Notification)
                ->request([
                    'user_id' => (int) $id,
                    'text' => $text,
                    'url' => $url,
                    'date' => time(),
                    'icon' => $icon,
                    'iconColor' => $iconColor
                ])->create();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
        
        return $this;
    }

    public function checkNotificationsByUrl(String $url)
    {
        $url = $this->shield(['url' => $url]);
        $url = rtrim(ForumConfiguration::$forumAddress, '/') . $url['url'];

        $myNotifications = (new Notification)
                ->where([
                    ['user_id', '=', $_SESSION['userHeavenLogged']['id']],
                    ['viewed', '=', 'false'],
                    ['url', '=', $url]
                ])
                ->orderBy('id', 'DESC')
                ->limit(20)
                ->execute(true);

        if (is_array($myNotifications)) {
            foreach($myNotifications as $notification) {
                $notification->viewed = 'true';
                $notification->save();
            }
        } else {
            if (isset($myNotifications->viewed)) {
                $myNotifications->viewed = 'true';
                $myNotifications->save();
            }
        }

        return $myNotifications ? $this->getNotifications(true) : false;
    }
}