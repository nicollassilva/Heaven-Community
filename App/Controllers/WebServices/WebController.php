<?php

namespace App\Controllers\WebServices;

use App\Controllers\_interfaces\WebServicesControllerInterface;
use App\Core\Utils\BaseApiController;
use App\Models\WebServices\Categories\Primary;
use App\Models\WebServices\Categories\Secondary;

class WebController extends BaseApiController implements WebServicesControllerInterface {
    protected $router;
    protected $repository;

    public function index()
    {
        $primaryCategories = new Primary();
        $secondCategories = new Secondary();
        $primaryCategories = $primaryCategories->show();

        if(is_array($primaryCategories)) {
            $allCategories = [];
            foreach($primaryCategories as $categorie) {
                $categorie['sub'] = $secondCategories->show($categorie['id']);
                $allCategories[] = $categorie;
            }
        }

        return $this->view('index',[
            'primaryCategories' => $allCategories ?? null
        ]);
    }

    public function create()
    {
        
    }

    public function update()
    {
        
    }
}