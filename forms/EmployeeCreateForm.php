<?php

namespace app\forms;

use app\models\Interview;
use Yii;
use yii\base\Model;

class EmployeeCreateForm extends Model
{
    public $orderDate;
    public $contractDate;
    public $recruitDate;
    public $firstName;
    public $lastName;
    public $address;
    public $email;

    private $interview;

    public function __construct(Interview $interview)
    {
        $this->interview = $interview;
        parent::__construct();
    }

    public function init()
    {
        $this->orderDate = date('Y-m-d');
        $this->contractDate = date('Y-m-d');
        $this->recruitDate = date('Y-m-d');
        $this->firstName = $this->interview->first_name;
        $this->lastName = $this->interview->last_name;
        $this->email = $this->interview->email;
    }

    public function rules()
    {
        return [
            [['orderDate', 'contractDate', 'recruitDate', 'firstName', 'lastName'], 'required'],
            [['orderDate', 'contractDate', 'recruitDate'], 'date', 'format' => 'php:Y-m-d'],
            [['firstName', 'lastName', 'email'], 'string', 'max' => 255],
            [['email'], 'email']
        ];
    }

    public function attributeLabels()
    {
        return [
            'orderDate' => 'Order Date',
            'contractDate' => 'Contract Date',
            'recruitDate' => 'Recruit Date',
            'firstName' => 'First Name',
            'lastName' => 'Last Name',
            'email' => 'Email',
        ];
    }


}