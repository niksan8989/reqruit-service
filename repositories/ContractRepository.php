<?php

namespace app\repositories;

use app\models\Contract;

class ContractRepository implements ContractRepositoryInterface
{
    /**
     * @param $id
     * @return Contract
     * @throws \InvalidArgumentException
     */
    public function find($id){
        if(!$contract = Contract::findOne($id)){
            throw new \InvalidArgumentException('Model not found');
        }
        return $contract;
    }

    public function add(Contract $contract){
        if(!$contract->getIsNewRecord()){
            throw new \InvalidArgumentException('Model always exists');
        }
        $contract->insert(false);
    }

    public function save(Contract $contract){
        if($contract->getIsNewRecord()){
            throw new \InvalidArgumentException('Model does not exist');
        }
        $contract->update(false);
    }
}