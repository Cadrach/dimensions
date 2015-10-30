<?php

namespace App\Models\Relations;

use App\Models\Relation;
use App\Models\Settings\Personnage;

class MarriedTo extends Relation
{
    public function isValid(){
        if( ! $this->source instanceof Personnage){
            throw new \Exception('Source must be an instance of Personnage');
        }
        if( ! $this->target instanceof Personnage){
            throw new \Exception('Target must be an instance of Personnage');
        }

        //Source must not be married to anyone
        foreach($this->source->getRelations() as $relation){
            if($relation instanceof MarriedTo){
                return false;
            }
        }
        //Target must not be married to anyone but source
        foreach($this->target->getRelations() as $relation){
            if($relation instanceof MarriedTo && $relation->getTarget() !== $this->getSource()){
                return false;
            }
        }
        return true;
    }

    public function onAdd(){
        if( ! $this->hasReverseRelation()){
            $backward = new MarriedTo($this->target, $this->source);
            $this->target->addRelation($backward);
        }
    }
}
