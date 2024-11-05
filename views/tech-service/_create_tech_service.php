<?php

use kartik\editors\Summernote;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;

?>
<?php Modal::begin([
    'id' => 'modal-create-tech-service',
    'title' => 'Add Tech Service',
    'size' => 'modal-lg',
    'headerOptions' => [
        'class' => 'bg-primary'
    ],
    'closeButton' => [
        'class' => 'close text-white'
    ]
]); ?>

<div class="tech-service-form">
    <?php $form = ActiveForm::begin([
        'id' => 'form-create',
        'action' => 'create',
        'options' => [],
        'method' => 'POST',
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<?php Modal::end(); ?>