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
        $category = $this->categoryTwo->findByUrl($response['handle'], false);
            
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

    public function delegateRouters(Array $data)
    {
        if(!isset($data['categorieOne']) || !isset($data['categorieTwo']))
            return $this->view("error");

        $response = $this->model->shield($data);

        $catOne = strip_tags($response['categorieOne']);
        $catTwo = strip_tags($response['categorieTwo']);
        $catThree = isset($response['categorieThree']) ? strip_tags($response['categorieThree']) : null;

        if(isset($catThree)) {
            $secondary = $this->categoryTwo->find($catOne)->execute();

            if(!$secondary)
                return $this->view("error");

            $tertiary = $this->categoryThree->findByUrlFather($catTwo, $secondary['id'], false);

            if(!$tertiary)
                return $this->view("error");

            $quaternary = $this->categoryFour->findByUrlFather($catThree, $tertiary['id'], false);

            if(!$quaternary)
                return $this->view("error");

            return $this->view("discussions/categories/topics", [
                'secondary' => $secondary,
                'tertiary' => $tertiary,
                'quaternary' => $quaternary
            ]);
        } else {
            $secondary = $this->categoryTwo->findByUrl($catOne, false);

            if(!$secondary)
                return $this->view("error");

            $tertiary = $this->categoryThree->findByUrlFather($catTwo, $secondary['id'], false);

            if(!$tertiary)
                return $this->view("error");

            $quaternary = $this->categoryFour->show($tertiary['id']);
                
            return $this->view("discussions/categories/index", [
                'secondary' => $secondary,
                'tertiary' => $tertiary,
                'quaternary' => $quaternary
            ]);
        }
    }

    public function create()
    {
        
    }

    public function update()
    {
        
    }
}