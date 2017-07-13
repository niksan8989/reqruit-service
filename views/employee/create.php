<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Employee */

$this->title = 'Create Employee';
$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($createForm, 'orderDate')->textInput() ?>

    <?= $form->field($createForm, 'contractDate')->textInput() ?>

    <?= $form->field($createForm, 'recruitDate')->textInput() ?>

    <?= $form->field($createForm, 'firstName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($createForm, 'lastName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($createForm, 'address')->textInput() ?>

    <?= $form->field($createForm, 'email')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Join', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
