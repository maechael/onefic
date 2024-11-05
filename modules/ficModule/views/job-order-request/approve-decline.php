<?php

use kartik\editors\Summernote;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\JobOrderRequest */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="job-order-request-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-4">
            <?= $form->field($model, 'requestor')->textInput(['maxlength' => true, 'disabled' => true]) ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'requestor_contact')->textInput(['maxlength' => true, 'disabled' => true]) ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'request_date')->input('date', ['class' => 'form-control', 'disabled' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <?= $form->field($model, 'request_type')->widget(Select2::class, [
                'data' => [
                    'Planning & Aquisition' => 'Planning & Aquisition',
                    'Test & Calibration' => 'Test & Calibration',
                    'Repair & Maintenance' => 'Repair & Maintenance'
                ],
                // 'size' => Select2::SMALL,
                'options' => ['placeholder' => 'Select a request type...'],
                'pluginOptions' => [
                    //'allowClear' => true
                ],
                'disabled' => true
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <label>Description</label>
            <div class="card">
                <div class="card-body">
                    <?= $model->request_description ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            <?= $form->field($model, 'request_noted_by')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'request_approved_by')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'request_personnel_in_charge')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Approve', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>