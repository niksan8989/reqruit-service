<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%interview}}".
 *
 * @property integer $id
 * @property string $date
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property integer $status
 * @property string $reject_reason
 * @property integer $employee_id
 *
 * @property Employee $employee
 */
class Interview extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 1;
    const STATUS_PASS = 2;
    const STATUS_REJECT = 3;

    public static function getStatusList()
    {
        return [
            self::STATUS_NEW => 'New',
            self::STATUS_PASS => 'Passed',
            self::STATUS_REJECT=> 'Rejected',
        ];
    }

    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusList(), $this->status);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%interview}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'status' => 'Status',
            'reject_reason' => 'Reject Reason',
            'employee_id' => 'Employee ID',
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
     * @inheritdoc
     * @return \app\models\query\InterviewQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\InterviewQuery(get_called_class());
    }

    public static function create($last_name, $first_name, $email, $date)
    {
        $interview = new Interview();
        $interview->date = $date;
        $interview->first_name = $first_name;
        $interview->last_name = $last_name;
        $interview->email = $email;
        $interview->status = Interview::STATUS_NEW;
        return $interview;
    }

    public function editData($last_name, $first_name, $email)
    {
        $this->last_name = $last_name;
        $this->first_name = $first_name;
        $this->email = $email;
    }

    public function reject($reason)
    {
        $this->guardNotRejected();
        $this->reject_reason = $reason;
        $this->status = self::STATUS_REJECT;
    }

    public function pass($employee_id)
    {
        $this->guardNotPassed();
        $this->employee_id = $employee_id;
        $this->status = Interview::STATUS_PASS;
    }

    public function isRecruitable()
    {
        return $this->status != self::STATUS_PASS;
    }

    protected function guardNotRejected()
    {
        if ($this->status == self::STATUS_REJECT) {
            throw new \DomainException('Interview is already rejected');
        }
    }

    protected function guardNotPassed()
    {
        if ($this->status == self::STATUS_PASS) {
            throw new \DomainException('Interview is already rejected');
        }
    }
}
