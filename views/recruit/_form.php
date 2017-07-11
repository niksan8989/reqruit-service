<?php

use app\models\Order;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Employee;

/* @var $this yii\web\View */
/* @var $model app\models\Recruit */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="recruit-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'order_id')->dropDownList(ArrayHelper::map(Order::find()->all(), 'id', 'id')) ?>

    <?= $form->field($model, 'employee_id')->dropDownList(ArrayHelper::map(Employee::find()->all(), 'id', 'fullName')) ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
