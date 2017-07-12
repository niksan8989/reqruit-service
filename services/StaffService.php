<?php

namespace app\services;

use app\repositories\InterviewRepositoryInterface;
use Yii;
use app\models\Interview;

class StaffService
{
    private $interviewRepository;
    private $logger;
    private $notificator;

    public function __construct(
        InterviewRepositoryInterface $interviewRepository,
        LoggerInterface $logger,
        NotificatorInterface $notificator
    ) {
       $this->interviewRepository = $interviewRepository;
       $this->logger = $logger;
       $this->notificator = $notificator;
    }

    public function joinToInterview($last_name, $first_name, $email, $date) {

        $interview = Interview::create($last_name, $first_name, $email, $date);

        $this->interviewRepository->add($interview);
        $interview->save(false);

        if ($interview->email) {
            $this->notificator->notify('interview/join', ['model' => $this], $interview, 'You are joined to the interview');
        }

        $this->logger->log('Interview ' . $interview->id . ' is created');

        return $interview;
    }

    public function editInterview($id, $last_name, $first_name, $email){

        $interview = $this->interviewRepository->find($id);
        $interview->editData($last_name, $first_name, $email);

        $this->interviewRepository->save($interview);
        $this->logger->log('Interview ' . $interview->id . ' is updated');
    }

    public function rejectInterview($id, $reason) {

        $interview = $this->interviewRepository->find($id);
        $interview->reject($reason);
        $this->interviewRepository->save($interview);

        $this->logger->log('Interview ' . $interview->id . ' is rejected');
    }
}