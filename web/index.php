<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');

$local_path_config = __DIR__ . '/../config/web-local.php';
if (file_exists($local_path_config)){
    $config = \yii\helpers\ArrayHelper::merge(
        $config,
        require($local_path_config)
    );
}

(new yii\web\Application($config))->run();