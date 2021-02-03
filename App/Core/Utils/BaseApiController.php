<?php

namespace App\Core\Utils;

use App\Core\Utils\BaseController;

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
            $title = $typeMessage === 'error' ? 'Oops...' : ($typeMessage === 'warning' ? 'Hey...' : 'Yeah!');
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
}
