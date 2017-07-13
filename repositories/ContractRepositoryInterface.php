<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 13.07.2017
 * Time: 18:52
 */

namespace app\repositories;

use app\models\Contract;

interface ContractRepositoryInterface
{
    /**
     * @param $id
     * @return Contract
     * @throws \InvalidArgumentException
     */
    public function find($id);

    public function add(Contract $contract);

    public function save(Contract $contract);
}