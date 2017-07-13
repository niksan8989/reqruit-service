<?php

namespace app\repositories;

use app\models\Employee;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    /**
     * @param $id
     * @return Employee
     * @throws \InvalidArgumentException
     */
    public function find($id){
        if(!$employee = Employee::findOne($id)){
            throw new \InvalidArgumentException('Model not found');
        }
        return $employee;
    }

    public function add(Employee $employee){
        if(!$employee->getIsNewRecord()){
            throw new \InvalidArgumentException('Model always exists');
        }
        $employee->insert(false);
    }

    public function save(Employee $employee){
        if($employee->getIsNewRecord()){
            throw new \InvalidArgumentException('Model does not exist');
        }
        $employee->update(false);
    }
}