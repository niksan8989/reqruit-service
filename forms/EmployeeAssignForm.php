<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 13.07.2017
 * Time: 22:03
 */

namespace app\forms;

use app\models\Employee;
use yii\base\Model;


class EmployeeAssignForm extends Model
{
    public $positionID;
    public $date;
    public $rate;
    public $salary;
    public $active;

    public function init()
    {
        $this->date = date('Y-m-d');
    }

    public function rules()
    {
        return [
            [['date', 'rate', 'salary', 'active', 'positionID'], 'required'],
            [['active', 'salary', 'positionID'], 'integer'],
            [['rate'], 'double'],
            [['date'], 'date', 'format' => 'php:Y-m-d']
        ];
    }

    public function attributeLabels()
    {
        return [
            'date' => 'Date',
            'rate' => 'Rate',
            'salary' => 'Salary',
            'active' => 'Active',
        ];
    }
}