<?php
namespace app\services;

use Yii;

class TransactionManager
{
    public function begin()
    {
        return new Transaction(Yii::$app->db->beginTransaction());
    }
}