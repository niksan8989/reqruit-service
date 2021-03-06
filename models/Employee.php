<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%employee}}".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $address
 * @property string $email
 * @property integer $status
 *
 * @property Assignment[] $assignments
 * @property Bonus[] $bonuses
 * @property Dismiss[] $dismisses
 * @property Interview[] $interviews
 * @property Recruit[] $recruits
 * @property Vacation[] $vacations
 */
class Employee extends \yii\db\ActiveRecord
{
    const STATUS_PROBATION = 1;
    const STATUS_WORK = 2;
    const STATUS_VACATION = 3;
    const STATUS_DISMISS = 4;

    const SCENARIO_CREATE = 'create';

    public $order_date;
    public $contract_date;
    public $recruit_date;


    public static function getStatusList()
    {
        return [
            self::STATUS_PROBATION => 'Probation',
            self::STATUS_WORK => 'Work',
            self::STATUS_VACATION => 'Vacation',
            self::STATUS_DISMISS => 'Dismiss',
        ];
    }

    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusList(), $this->status);
    }

    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public static function create($last_name, $first_name, $address, $email)
    {
        $employee = new self();
        $employee->last_name = $last_name;
        $employee->first_name = $first_name;
        $employee->address = $address;
        $employee->email = $email;
        $employee->status = self::STATUS_PROBATION;
        return $employee;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%employee}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'address' => 'Address',
            'email' => 'Email',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignments()
    {
        return $this->hasMany(Assignment::className(), ['employee_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBonuses()
    {
        return $this->hasMany(Bonus::className(), ['employee_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDismisses()
    {
        return $this->hasMany(Dismiss::className(), ['employee_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInterviews()
    {
        return $this->hasMany(Interview::className(), ['employee_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecruits()
    {
        return $this->hasMany(Recruit::className(), ['employee_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVacations()
    {
        return $this->hasMany(Vacation::className(), ['employee_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\query\EmployeeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\EmployeeQuery(get_called_class());
    }
}
