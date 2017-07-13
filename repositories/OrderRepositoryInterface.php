<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 13.07.2017
 * Time: 18:40
 */

namespace app\repositories;

use app\models\Order;

interface OrderRepositoryInterface
{
    /**
     * @param $id
     * @return Order
     * @throws \InvalidArgumentException
     */
    public function find($id);

    public function add(Order $Order);

    public function save(Order $Order);
}