<?php

namespace App\Core\Utils;

use App\Core\Utils\BaseController;
use App\Languages\GetLanguage;

class BaseApiController extends BaseController {
    protected $messageTypes = ['warning', 'success', 'error'];
    protected $response;

    /**
     * @param string $response
     * @param string $typeMessage
     * @return array
     */
    public function response(String $response, String $typeMessage = 'error', String $href = "", Array $data = [])
    {
        if(in_array($typeMessage, $this->messageTypes)) {
            $title = $typeMessage === 'error' ? GetLanguage::get('notification_title_error') : ($typeMessage === 'warning' ? GetLanguage::get('notification_title_warning') : GetLanguage::get('notification_title_success'));
        } else {
            $typeMessage = 'error';
            $title = 'Oops...';
        }
        $redirect = $href != "" ? $href : "";
        $this->response = [$typeMessage => true, 'msg' => $response, 'title' => $title, 'href' => $redirect, 'data' => $data];
        
        echo json_encode($this->response);
    }

    public function checkPage()
    {
        return explode("/", $_SERVER['HTTP_REFERER'])[4] ?? null;
    }

    public function resetCsrf()
    {
        if(isset($_SESSION['_CSRF']))
            unset($_SESSION['_CSRF']);

        return $this;
    }
}
