<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class Setting //extends Model
{
    //
    protected $relations = [];

    public function addRelation(Relation $relation){
        if($relation->getSource() !== $this){
            throw new \Exception('Must be the source of the relation');
        }
        if( ! $relation->isValid()){
            throw new \Exception("Invalid relation $relation between {$relation->getSource()} and {$relation->getTarget()}");
        }

        $this->relations[] = $relation;
        $relation->onAdd();
    }

    public function getRelations(){
        return $this->relations;
    }

    public function __toString(){
        return str_replace(__NAMESPACE__ . '\\', '', get_class($this));
    }
}
