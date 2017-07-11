<?php

namespace app\services;

use Yii;

class Notificator
{
    /**
     * @param $view
     * @param $data
     * @param $interview
     * @param $subject
     */
    public function notify($view, $data, $interview, $subject)
    {
        Yii::$app->mailer->compose($view, $data)
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setTo($interview->email)
            ->setSubject($subject)
            ->send();
    }
}