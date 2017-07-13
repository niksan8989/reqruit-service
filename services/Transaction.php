<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 13.07.2017
 * Time: 20:40
 */

namespace app\services;


use Yii;

class Transaction
{
    private $transaction;

    public function __construct(\yii\db\Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function commit()
    {
        return $this->transaction->commit();
    }

    public function rollback()
    {
        return $this->transaction->rollback();
    }
}