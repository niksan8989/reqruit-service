<?php

namespace app\services;

use app\models\Log;
use Yii;
use app\models\Interview;

class StaffService
{
    public function joinToInterview($last_name, $first_name, $email, $date) {

        $interview = Interview::create($last_name, $first_name, $email, $date);
        $interview->save(false);

        if ($interview->email) {
            Yii::$app->mailer->compose('interview/join', ['model' => $this])
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setTo($interview->email)
                ->setSubject('You are joined to the interview')
                ->send();
        }

        $log = new Log();
        $log->message = 'Interview ' . $interview->id . ' is created';
        $log->save();

        return $interview;
    }

    public function editInterview($id, $last_name, $first_name, $email){
        /**
         * @var Interview $interview
         */
        if (!$interview = Interview::findOne($id)) {
            throw new \InvalidArgumentException('Model not found');
        }

        $interview->editData($last_name, $first_name, $email);

        $interview->save(false);

        $log = new Log();
        $log->message = 'Interview ' . $interview->id . ' is updated';
        $log->save();
    }
}