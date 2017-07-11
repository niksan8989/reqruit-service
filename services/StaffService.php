<?php

namespace app\services;

use app\models\Log;
use app\repositories\InterviewRepository;
use Yii;
use app\models\Interview;

class StaffService
{
    private $interviewRepository;

    public function __construct(InterviewRepository $interviewRepository)
    {
       $this->interviwRepository = $interviewRepository;
    }

    public function joinToInterview($last_name, $first_name, $email, $date) {

        $interview = Interview::create($last_name, $first_name, $email, $date);

        $this->interviwRepository->add($interview);
        $interview->save(false);

        if ($interview->email) {
            $this->notify('interview/join', ['model' => $this], $interview, 'You are joined to the interview');
        }

        $this->log('Interview ' . $interview->id . ' is created');

        return $interview;
    }

    public function editInterview($id, $last_name, $first_name, $email){

        $interview = $this->interviwRepository->find($id);
        $interview->editData($last_name, $first_name, $email);

        $this->interviwRepository->save($interview);
        $this->log('Interview ' . $interview->id . ' is updated');
    }

    public function rejectInterview($id, $reason) {

        $interview = $this->interviwRepository->find($id);
        $interview->reject($reason);
        $this->interviwRepository->save($interview);

        $this->log('Interview ' . $interview->id . ' is rejected');
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