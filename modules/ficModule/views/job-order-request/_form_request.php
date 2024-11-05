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
            <?= $form->field($model, 'requestor')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'requestor_contact')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-4">
            <?= $form->field($model, 'request_date')->input('date', ['class' => 'form-control']) ?>
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
                ]
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <?= $form->field($model, 'request_description')->widget(Summernote::class, [
                'useKrajeePresets' => true,
                'container' => [
                    'class' => ''
                ]
            ]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>