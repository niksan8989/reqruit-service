<?php

use app\models\Position;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use \yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $assignForm app\forms\EmployeeAssignForm */

$this->title = 'Assign Employee';
$this->params['breadcrumbs'][] = ['label' => 'Assigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="assign-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="assign-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($assignForm, 'positionID')->dropDownList(ArrayHelper::map(Position::find()->all(), 'id', 'name')) ?>

        <?= $form->field($assignForm, 'date')->textInput() ?>

        <?= $form->field($assignForm, 'rate')->textInput() ?>

        <?= $form->field($assignForm, 'salary')->textInput() ?>

        <?= $form->field($assignForm, 'active')->checkbox() ?>

        <div class="form-group">
            <?= Html::submitButton('Join', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>


</div>