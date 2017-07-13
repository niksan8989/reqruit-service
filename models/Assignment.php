<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%assignment}}".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $employee_id
 * @property integer $position_id
 * @property string $date
 * @property string $rate
 * @property integer $salary
 * @property integer $active
 *
 * @property Position $position
 * @property Employee $employee
 * @property Order $order
 */
class Assignment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%assignment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'employee_id', 'position_id', 'date', 'rate', 'salary', 'active'], 'required'],
            [['order_id', 'employee_id', 'position_id', 'salary', 'active'], 'integer'],
            [['date'], 'safe'],
            [['rate'], 'number'],
            [['position_id'], 'exist', 'skipOnError' => true, 'targetClass' => Position::className(), 'targetAttribute' => ['position_id' => 'id']],
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
            'position_id' => 'Position ID',
            'date' => 'Date',
            'rate' => 'Rate',
            'salary' => 'Salary',
            'active' => 'Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosition()
    {
        return $this->hasOne(Position::className(), ['id' => 'position_id']);
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
     * @return \app\models\query\AssignmentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\AssignmentQuery(get_called_class());
    }

    public static function create(
        $order_id,
        $employee_id,
        $position_id,
        $date,
        $rate,
        $salary,
        $active
    )
    {
        $assignment = new self();
        $assignment->order_id = $order_id;
        $assignment->employee_id = $employee_id;
        $assignment->position_id = $position_id;
        $assignment->date = $date;
        $assignment->rate = $rate;
        $assignment->salary = $salary;
        $assignment->active = $active;
        return $assignment;
    }
}
