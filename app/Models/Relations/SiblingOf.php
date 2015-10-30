<?php

namespace App\Models\Relations;

use App\Models\Relation;

class SiblingOf extends Relation
{
    public function onAdd(){
        if( ! $this->hasReverseRelation()){
            $backward = new SiblingOf($this->target, $this->source);
            $this->target->addRelation($backward);
        }
    }
}
