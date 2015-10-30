<?php

namespace App\Models\Relations;

use App\Models\Relation;

class ParentOf extends Relation
{
    public function onAdd(){
        if( ! $this->targetHasRelation(__NAMESPACE__ . '\ChildOf')){
            $relation = new ChildOf($this->target, $this->source);
            $this->target->addRelation($relation);
        }
    }
}
