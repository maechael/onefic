<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\JobOrderRequest */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="job-order-request-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'request_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'requestor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'requestor_contact')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'requestor_profile_id')->textInput() ?>

    <?= $form->field($model, 'request_description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'request_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>