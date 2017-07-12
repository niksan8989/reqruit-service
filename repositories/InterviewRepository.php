<?php

namespace app\repositories;

use app\models\Interview;

class InterviewRepository implements InterviewRepositoryInterface
{
    /**
     * @param $id
     * @return Interview
     * @throws \InvalidArgumentException
     */
    public function find($id){
        if(!$interview = Interview::findOne($id)){
            throw new \InvalidArgumentException('Model not found');
        }
        return $interview;
    }

    public function add(Interview $interview){
        if(!$interview->getIsNewRecord()){
            throw new \InvalidArgumentException('Model always exists');
        }
        $interview->insert(false);
    }

    public function save(Interview $interview){
        if($interview->getIsNewRecord()){
            throw new \InvalidArgumentException('Model does not exist');
        }
        $interview->update(false);
    }
}