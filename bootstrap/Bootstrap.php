<?php

namespace app\bootstrap;

use Yii;
use yii\base\Application;

class Bootstrap implements \yii\base\BootstrapInterface
{
    public function bootstrap($app){
        $container = Yii::$container;

        $container->setSingleton('app\repositories\InterviewRepositoryInterface','app\repositories\InterviewRepository');
        $container->setSingleton('app\repositories\EmployeeRepositoryInterface','app\repositories\EmployeeRepository');
        $container->setSingleton('app\repositories\OrderRepositoryInterface','app\repositories\OrderRepository');
        $container->setSingleton('app\repositories\ContractRepositoryInterface','app\repositories\ContractRepository');
        $container->setSingleton('app\services\LoggerInterface','app\services\Logger');
        $container->setSingleton('app\services\NotificatorInterface','app\services\Notificator');
    }
}