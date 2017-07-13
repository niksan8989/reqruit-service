<?php

namespace app\repositories;

use app\models\Position;

class PositionRepository implements PositionRepositoryInterface
{
    /**
     * @param $id
     * @return Position
     * @throws \InvalidArgumentException
     */
    public function find($id){
        if(!$position = Position::findOne($id)){
            throw new \InvalidArgumentException('Model not found');
        }
        return $position;
    }

    public function add(Position $position){
        if(!$position->getIsNewRecord()){
            throw new \InvalidArgumentException('Model always exists');
        }
        $position->insert(false);
    }

    public function save(Position $position){
        if($position->getIsNewRecord()){
            throw new \InvalidArgumentException('Model does not exist');
        }
        $position->update(false);
    }
}