<?php

namespace App\Controllers\WebServices;

use App\Controllers\_interfaces\WebServicesControllerInterface;
use App\Core\Utils\BaseApiController;
use App\Models\WebServices\Categories\{
    Primary,
    Quaternary,
    Secondary,
    Tertiary
};

class CategoryController extends BaseApiController implements WebServicesControllerInterface {
    protected $router;
    protected $model;
    protected $categoryTwo;
    protected $categoryThree;
    protected $categoryFour;
    
    function __construct(Object $router)
    {
        $this->router = $router;
        $this->model = new Primary();
        $this->categoryTwo = new Secondary();
        $this->categoryThree = new Tertiary();
        $this->categoryFour = new Quaternary();
    }
    
    public function index(Array $data)
    {
        $response = $this->model->shield($data);
        $category = $this->categoryTwo->findByUrl($response['handle']);
            
        if (is_array($category)) {
            $childsCategory = $this->categoryThree->findByFather($category['id']);
            
            $fatherId = (int) $category['categorie_primary_id'];
            $fatherCategory = (new Primary)
                ->whereRaw("id = '${fatherId}' AND visible = 'true'")
                ->limit(1)
                ->execute();

            if ($fatherCategory) {
                return $this->view("discussions/category", [
                    'primary' => $fatherCategory,
                    'secondary' => $category,
                    'tertiary' => $childsCategory,
                    'quaternary' => function(Int $id) {
                        return $this->categoryFour->show($id);
                    }
                ]);
            } else {
                return $this->view("error");
            }
        } else {
            return $this->view("error");
        }

        
    }

    public function create()
    {
        
    }

    public function update()
    {
        
    }
}