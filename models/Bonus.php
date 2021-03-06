<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%bonus}}".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $employee_id
 * @property integer $cost
 *
 * @property Employee $employee
 * @property Order $order
 */
class Bonus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%bonus}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'employee_id', 'cost'], 'required'],
            [['order_id', 'employee_id', 'cost'], 'integer'],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['employee_id' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'employee_id' => 'Employee ID',
            'cost' => 'Cost',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::className(), ['id' => 'employee_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\query\BonusQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\BonusQuery(get_called_class());
    }
}
