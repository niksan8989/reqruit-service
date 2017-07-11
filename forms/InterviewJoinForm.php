<?php

namespace app\forms;

use Yii;
use yii\base\Model;

class InterviewJoinForm extends Model
{
    public $date;
    public $first_name;
    public $last_name;
    public $email;

    public function init()
    {
        $this->date = date('Y-m-d');
    }

    public function rules()
    {
        return [
            [['date', 'first_name', 'last_name'], 'required'],
            [['date'], 'date', 'format' => 'php:Y-m-d'],
            [['first_name', 'last_name', 'email'], 'string', 'max' => 255],
            [['email'], 'email']
        ];
    }

    public function attributeLabels()
    {
        return [
            'date' => 'Date',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
        ];
    }


}