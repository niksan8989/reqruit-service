<?php

namespace app\forms;

use app\models\Interview;
use Yii;
use yii\base\Model;

class InterviewEditForm extends Model
{
    public $firstName;
    public $lastName;
    public $email;

    private $interview;

    public function __construct(Interview $interview, array $config = [])
    {
        $this->interview = $interview;
        parent::__construct($config);
    }

    public function init()
    {
        // Если бы все имена даннной модели совпадали бы с моделью Interview, то можно было бы использовать метод setAttributes и не заполнять каждое поле вручную
        $this->firstName = $this->interview->first_name;
        $this->lastName = $this->interview->last_name;
        $this->email = $this->interview->email;
    }

    public function rules()
    {
        return [
            [['firstName', 'lastName'], 'required'],
            [['firstName', 'lastName', 'email'], 'string', 'max' => 255],
            [['email'], 'email']
        ];
    }

    public function attributeLabels()
    {
        return [
            'firstName' => 'First Name',
            'lastName' => 'Last Name',
            'email' => 'Email',
        ];
    }


}