<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 13.07.2017
 * Time: 18:19
 */

namespace app\repositories;

use app\models\Employee;

interface EmployeeRepositoryInterface
{
    /**
     * @param $id
     * @return Employee
     * @throws \InvalidArgumentException
     */
    public function find($id);

    public function add(Employee $Employee);

    public function save(Employee $Employee);
}