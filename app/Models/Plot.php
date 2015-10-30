<?php

namespace App\Models;

use App\Models\Settings\Personnage;

class Plot
{
    public $numberOfCharacters = 10;
    public $numberOfLocations = 5;

    protected $characters = [];

    //
    public function generate(){
        for($i=1; $i<=$this->numberOfCharacters;$i++){
            $this->characters[] = new Personnage();
        }
    }
}
