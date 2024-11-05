<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\ficModule\models\JobOrderRequestSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row mt-2">
    <div class="col-md-12">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'fic_id') ?>

    <?= $form->field($model, 'request_type') ?>

    <?= $form->field($model, 'requestor') ?>

    <?= $form->field($model, 'requestor_contact') ?>

    <?php // echo $form->field($model, 'requestor_profile_id') ?>

    <?php // echo $form->field($model, 'request_description') ?>

    <?php // echo $form->field($model, 'request_date') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'date_approved') ?>

    <?php // echo $form->field($model, 'request_approved_by') ?>

    <?php // echo $form->field($model, 'request_noted_by') ?>

    <?php // echo $form->field($model, 'request_personnel_in_charge') ?>

    <?php // echo $form->field($model, 'date_accomplished') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    </div>
    <!--.col-md-12-->
</div>
