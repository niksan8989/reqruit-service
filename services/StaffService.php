<?php

namespace app\services;

use app\models\Assignment;
use app\models\Contract;
use app\models\Employee;
use app\models\Order;
use app\models\Position;
use app\models\Recruit;
use app\repositories\ContractRepositoryInterface;
use app\repositories\EmployeeRepositoryInterface;
use app\repositories\InterviewRepositoryInterface;
use app\repositories\OrderRepositoryInterface;
use Yii;
use app\models\Interview;

class StaffService
{
    private $interviewRepository;
    private $employeeRepository;
    private $orderRepository;
    private $contractRepository;
    private $transactionManager;
    private $logger;
    private $notificator;

    public function __construct(
        InterviewRepositoryInterface $interviewRepository,
        EmployeeRepositoryInterface $employeeRepository,
        OrderRepositoryInterface $orderRepository,
        ContractRepositoryInterface $contractRepository,
        TransactionManager $transactionManager,
        LoggerInterface $logger,
        NotificatorInterface $notificator
    ) {
       $this->interviewRepository = $interviewRepository;
       $this->employeeRepository = $employeeRepository;
       $this->orderRepository = $orderRepository;
       $this->contractRepository = $contractRepository;
       $this->transactionManager = $transactionManager;
       $this->logger = $logger;
       $this->notificator = $notificator;
    }

    public function joinToInterview($last_name, $first_name, $email, $date) {

        $interview = Interview::create($last_name, $first_name, $email, $date);

        $this->interviewRepository->add($interview);

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

    public function createEmployee(
        $interview_id,
        $last_name,
        $first_name,
        $address,
        $email,
        $order_date,
        $contract_date,
        $recruit_date
    ){

        try {
            $interview = $this->interviewRepository->find($interview_id);
        } catch (\InvalidArgumentException $e){
            $interview = null;
        }

        $transaction = $this->transactionManager->begin();

        try {
            $employee = Employee::create(
                $last_name,
                $first_name,
                $address,
                $email
            );

            $this->employeeRepository->add($employee);

            if ($interview) {
                $interview->pass($employee->id);
                $this->interviewRepository->save($interview);
            }

            $order = Order::create($order_date);
            $this->orderRepository->add($order);

            $contract = Contract::create(
                $employee->id,
                $first_name,
                $last_name,
                $contract_date
            );
            $this->contractRepository->add($contract);

            /*$recruit = new Recruit();
            $recruit->employee_id = $model->id;
            $recruit->order_id = $order->id;
            $recruit->date = $model->recruit_date;
            $recruit->save(false);*/

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

        return $employee;
    }

    public function assignEmployee(
        $employee_id,
        $position_id,
        $date,
        $rate,
        $salary,
        $active
    )
    {

        $order = Order::create($date);
        $this->orderRepository->add($order);

        $assignment = Assignment::create(
            $order->id,
            $employee_id,
            $position_id,
            $date,
            $rate,
            $salary,
            $active
        );

        $assignment->save(false);

        return $assignment;

    }

}