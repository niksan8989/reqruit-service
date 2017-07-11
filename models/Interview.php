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
    const SCENARIO_CREATE = 'create';

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

    public function getNextStatusList()
    {
        if ($this->status == self::STATUS_PASS) {
            return [
                self::STATUS_PASS => 'Passed',
            ];
        } elseif ($this->status == self::STATUS_REJECT) {
            return [
                self::STATUS_PASS => 'Passed',
                self::STATUS_REJECT=> 'Rejected',
            ];
        } else {
            return [
                self::STATUS_NEW => 'New',
                self::STATUS_PASS => 'Passed',
                self::STATUS_REJECT=> 'Rejected',
            ];
        }

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
    public function rules()
    {
        return [
            [['date', 'first_name', 'last_name'], 'required'],
            [['status'], 'required', 'except' => self::SCENARIO_CREATE],
            [['status'], 'default', 'value' => self::STATUS_NEW],
            [['date'], 'safe'],
            [['status', 'employee_id'], 'integer', 'except' => self::SCENARIO_CREATE],
            [['reject_reason'], 'required', 'when' => function($model) {
                return $model->status == self::STATUS_REJECT;
            }, 'whenClient' => "function (attribute, value) {
                return $('#interview-status').val() == '" . self::STATUS_REJECT . "';
            }"],
            [['reject_reason'], 'string'],
            [['first_name', 'last_name', 'email'], 'string', 'max' => 255],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['employee_id' => 'id']],
        ];
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

    public function afterSave($insert, $changedAttributes)
    {
        if (in_array('status', $changedAttributes) && $this->status != $changedAttributes['status']) {
            if ($this->status == self::STATUS_NEW) {

            } elseif ($this->status == self::STATUS_PASS) {
                if ($this->email) {
                    Yii::$app->mailer->compose('interview/pass', ['model' => $this])
                        ->setFrom(Yii::$app->params['adminEmail'])
                        ->setTo($this->email)
                        ->setSubject('You are passed the interview')
                        ->send();
                }
                $log = new Log();
                $log->message = $this->first_name . ' ' . $this->last_name . ' is passed the interview';
                $log->save();
            } elseif ($this->status == self::STATUS_REJECT) {
                if ($this->email) {
                    Yii::$app->mailer->compose('interview/reject', ['model' => $this])
                        ->setFrom(Yii::$app->params['adminEmail'])
                        ->setTo($this->email)
                        ->setSubject('You are failed the interview')
                        ->send();
                }
                $log = new Log();
                $log->message = $this->first_name . ' ' . $this->last_name . ' is failed to interview';
                $log->save();
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }
}
