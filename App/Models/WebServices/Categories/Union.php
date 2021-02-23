<?php

namespace App\Models\WebServices\Categories;

use App\Core\Utils\BaseApiModel;
use App\Models\WebServices\Categories\{
    Quaternary,
    Secondary,
    Tertiary
};

class Union extends BaseApiModel {
    protected $categoryTwo;
    protected $categoryThree;
    protected $categoryFour;

    function __construct()
    {
        parent::__construct('', 'id');
        $this->categoryTwo = new Secondary();
        $this->categoryThree = new Tertiary();
        $this->categoryFour = new Quaternary();
    }

    public function logicUrl($catOne, String $catTwo, ?String $catThree = null)
    {
        if(isset($catThree)) {
            $secondary = $this->categoryTwo->find($catOne)->execute();

            if(!$secondary)
                return false;

            $tertiary = $this->categoryThree->findByUrlFather($catTwo, $secondary['id'], false);

            if(!$tertiary)
                return false;

            $quaternary = $this->categoryFour->findByUrlFather($catThree, $tertiary['id'], false);

            if(!$quaternary)
                return false;

            return [
                'secondary' => $secondary,
                'tertiary' => $tertiary,
                'quaternary' => $quaternary
            ];
        } else {
            $secondary = $this->categoryTwo->findByUrl($catOne, false);

            if(!$secondary)
                return false;

            $tertiary = $this->categoryThree->findByUrlFather($catTwo, $secondary['id'], false);

            if(!$tertiary)
                return false;

            $quaternary = $this->categoryFour->show($tertiary['id']);
                
            return [
                'secondary' => $secondary,
                'tertiary' => $tertiary,
                'quaternary' => $quaternary
            ];
        }
    }
}