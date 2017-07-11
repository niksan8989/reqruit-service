<?php

namespace app\services;

use app\models\Log;
use Yii;
use app\models\Interview;

class StaffService
{
    public function joinToInterview($last_name, $first_name, $email, $date) {
        $interview = new Interview();
        $interview->date = $date;
        $interview->first_name = $first_name;
        $interview->last_name = $last_name;
        $interview->email = $email;
        $interview->status = Interview::STATUS_NEW;
        $interview->save();

        if ($interview->email) {
            Yii::$app->mailer->compose('interview/join', ['model' => $this])
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setTo($interview->email)
                ->setSubject('You are joined to the interview')
                ->send();
        }

        $log = new Log();
        $log->message = $interview->first_name . ' ' . $interview->last_name . ' is joined to interview';
        $log->save();

        return $interview;
    }
}