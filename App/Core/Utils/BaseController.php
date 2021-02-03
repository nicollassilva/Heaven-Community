<?php

namespace App\Core\Utils;

class BaseController {
    
    /**
     * @param string $nameView
     * @param array $resources
     */
    public function view(String $nameView, Array $resources = [])
    {
        $pathFile = dirname(__DIR__, 3) . DIRECTORY_SEPARATOR . 'Public' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $nameView . ".php";
        
        if (file_exists($pathFile)) {
            $resources != null ? extract($resources, EXTR_PREFIX_SAME, "wddx") : '';
            require_once $pathFile;
        }

        return null;
    }
}