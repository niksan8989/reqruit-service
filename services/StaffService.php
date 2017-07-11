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
            $this->notify('interview/join', ['model' => $this], $interview, 'You are joined to the interview');
        }

        $this->log('Interview ' . $interview->id . ' is created');

        return $interview;
    }

    public function editInterview($id, $last_name, $first_name, $email){

        $interview = $this->findInterviewModel($id);
        $interview->editData($last_name, $first_name, $email);
        $interview->save(false);

        $this->log('Interview ' . $interview->id . ' is updated');
    }

    public function rejectInterview($id, $reason) {

        $interview = $this->findInterviewModel($id);
        $interview->reject($reason);
        $interview->save(false);

        $this->log('Interview ' . $interview->id . ' is rejected');
    }

    /**
     * @param $id
     * @return Interview
     * @throws \InvalidArgumentException
     */
    protected function findInterviewModel($id){
        if (($model = Interview::findOne($id)) !== null) {
            return $model;
        } else {
            throw new \InvalidArgumentException('Model not found');
        }
    }

    protected function log($message){
        $log = new Log();
        $log->message = $message;
        $log->save();
    }

    /**
     * @param $view
     * @param $data
     * @param $interview
     * @param $subject
     */
    protected function notify($view, $data, $interview, $subject)
    {
        Yii::$app->mailer->compose($view, $data)
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setTo($interview->email)
            ->setSubject($subject)
            ->send();
    }


}