<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12.07.2017
 * Time: 18:27
 */

namespace app\services;

interface NotificatorInterface
{
    /**
     * @param $view
     * @param $data
     * @param $interview
     * @param $subject
     */
    public function notify($view, $data, $interview, $subject);
}