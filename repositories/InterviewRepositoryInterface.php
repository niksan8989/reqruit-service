<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12.07.2017
 * Time: 19:04
 */

namespace app\repositories;

use app\models\Interview;

interface InterviewRepositoryInterface
{
    /**
     * @param $id
     * @return Interview
     * @throws \InvalidArgumentException
     */
    public function find($id);

    public function add(Interview $interview);

    public function save(Interview $interview);
}