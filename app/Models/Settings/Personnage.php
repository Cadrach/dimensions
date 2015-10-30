<?php

namespace App\Models\Settings;

use App\Models\Setting;

class Personnage extends Setting
{
    //
    //protected $table = "setting_personnages";

    const GENDER_MALE = 'M';
    const GENDER_FEMALE = 'F';

    public $age = 0;

    public function setName($value){$this->name = $value;}
    public function setAge($value){$this->age = $value;}
    public function setGender($value){$this->gender = $value;}

    public function __toString(){
        $string = "Personnage [{$this->name}, {$this->gender} {$this->age}ans]";
        $string.= count($this->getRelations()) ? '<ul><li>'.implode('</li><li>', $this->getRelations()).'</li></ul>':'';
        return $string;
    }
}
