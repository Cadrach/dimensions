<?php

namespace App\Models\Relations;

use App\Models\Relation;

class ChildOf extends Relation
{
    public function onAdd(){
        if( ! $this->targetHasRelation(__NAMESPACE__ . '\ParentOf')){
            $relation = new ParentOf($this->target, $this->source);
            $this->target->addRelation($relation);
        }
    }
}
