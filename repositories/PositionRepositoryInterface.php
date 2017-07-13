<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 13.07.2017
 * Time: 23:41
 */

namespace app\repositories;

use app\models\Position;

interface PositionRepositoryInterface
{
    /**
     * @param $id
     * @return Position
     * @throws \InvalidArgumentException
     */
    public function find($id);

    public function add(Position $position);

    public function save(Position $position);
}