<?php

namespace app\repositories;

use app\models\Order;

class OrderRepository implements OrderRepositoryInterface
{
    /**
     * @param $id
     * @return Order
     * @throws \InvalidArgumentException
     */
    public function find($id){
        if(!$order = Order::findOne($id)){
            throw new \InvalidArgumentException('Model not found');
        }
        return $order;
    }

    public function add(Order $order){
        if(!$order->getIsNewRecord()){
            throw new \InvalidArgumentException('Model always exists');
        }
        $order->insert(false);
    }

    public function save(Order $order){
        if($order->getIsNewRecord()){
            throw new \InvalidArgumentException('Model does not exist');
        }
        $order->update(false);
    }
}