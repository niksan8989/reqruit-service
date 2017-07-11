<?php

namespace app\forms;

use Yii;
use yii\base\Model;

class InterviewRejectForm extends Model
{
    public $reason;

    public function rules()
    {
        return [
            [['reason'], 'required'],
            [['reason'], 'string']
        ];
    }

    public function attributeLabels()
    {
        return [
            'reason' => 'Reject Reason',
        ];
    }
}