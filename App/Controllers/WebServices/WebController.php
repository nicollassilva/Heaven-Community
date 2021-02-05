<?php

namespace App\Controllers\WebServices;

use App\Controllers\_interfaces\WebServicesControllerInterface;
use App\Core\Utils\BaseApiController;
use App\Models\WebServices\Categories\Primary;
use App\Models\WebServices\Categories\Secondary;

class WebController extends BaseApiController implements WebServicesControllerInterface {
    protected $router;
    
    function __construct(Object $router)
    {
        $this->router = $router;
    }
    
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
            'primaryCategories' => $allCategories ?? null,
            'router' => $this->router
        ]);
    }

    public function register()
    {
        return $this->view('register', [
            'terms' => isset($_POST['terms']) ? true : false
        ]);
    }

    public function rules()
    {
        return $this->view('rules');
    }

    public function create()
    {
        
    }

    public function update()
    {
        
    }
}