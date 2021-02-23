<?php

namespace App\Models\Apis;

use App\Core\Utils\BaseApiModel;

class Balance extends BaseApiModel {

    function __construct()
    {
        parent::__construct('heaven_balance', 'id');
    }

    public function getStatistics(?Int $secondary = null, ?Int $tertiary = null, ?Int $quaternary = null)
    {
        return $this->where([
            [
                (
                    $secondary ? 'categorie_secondary_id' : (
                        $tertiary ? 'categorie_tertiary_id' : 'categorie_quaternary_id'
                    )
                ), '=', 
                (
                    $secondary ? $secondary : (
                        $tertiary ? $tertiary : $quaternary
                    )
                )
            ]
        ])->limit(1)->execute();
    }
}