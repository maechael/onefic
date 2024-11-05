<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EquipmentMaintenanceLog */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="equipment-maintenance-log-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fic_equipment_id')->textInput() ?>

    <?= $form->field($model, 'maintenance_date')->textInput() ?>

    <?= $form->field($model, 'time_started')->textInput() ?>

    <?= $form->field($model, 'time_ended')->textInput() ?>

    <?= $form->field($model, 'conclusion_recommendation')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'inspected_checked_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'noted_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
