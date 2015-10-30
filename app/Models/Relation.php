<?php

namespace App\Models;

use App\Models\Settings\Personnage;
use Illuminate\Database\Eloquent\Model;

abstract class Relation
{
    protected $influence = 0;
    protected $source;
    protected $target;

    public function __construct(Setting $source, Setting $target){
        $this->source = $source;
        $this->target = $target;
    }

    public function getSource(){return $this->source;}

    public function getTarget(){return $this->target;}

    public function isValid(){
        return true;
    }

    public function onAdd(){

    }

    /**
     * Returns TRUE if reverse relation found
     * @return bool
     */
    public function hasReverseRelation(){
        return $this->targetHasRelation(get_class($this));
    }

    /**
     * Returns TRUE if $class relation with source can be found for target
     * @param $class
     * @return bool
     */
    public function targetHasRelation($class){
        foreach($this->target->getRelations() as $relation){
            if(get_class($relation) == $class && $relation->getTarget() === $this->getSource() ){
                return true;
            }
        }
        return false;
    }

    public function __toString(){
        return str_replace(__NAMESPACE__ . '\\', '', get_class($this)) . " {$this->target->name}";
    }
}
