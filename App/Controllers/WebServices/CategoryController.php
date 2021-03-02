<?php

namespace App\Controllers\WebServices;

use App\Controllers\_interfaces\WebServicesControllerInterface;
use App\Core\Utils\BaseApiController;
use App\Models\Apis\Topic;
use App\Models\WebServices\Categories\{
    Primary,
    Quaternary,
    Secondary,
    Tertiary,
    Union
};

class CategoryController extends BaseApiController implements WebServicesControllerInterface {
    protected $router;
    protected $model;
    protected $categoryTwo;
    protected $categoryThree;
    protected $categoryFour;
    protected $unionCategory;
    protected $topics;
    
    function __construct(Object $router)
    {
        $this->router = $router;
        $this->model = new Primary();
        $this->categoryTwo = new Secondary();
        $this->categoryThree = new Tertiary();
        $this->categoryFour = new Quaternary();
        $this->topics = new Topic;
        $this->unionCategory = new Union;
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
            $logic = $this->unionCategory->logicUrl($catOne, $catTwo, $catThree);

            if(!$logic)
                return $this->view("error");

            return $this->view("discussions/categories/topics", [
                'secondary' => $logic['secondary'],
                'tertiary' => $logic['tertiary'],
                'quaternary' => $logic['quaternary'],
                'topics' => $this->topics->byCategorie($logic['quaternary']['id'])
            ]);
        } else {
            $logic = $this->unionCategory->logicUrl($catOne, $catTwo);

            if(!$logic)
                return $this->view("error");
                
            return $this->view("discussions/categories/index", $logic);
        }
    }

    public function create()
    {
        
    }

    public function update()
    {
        
    }
}