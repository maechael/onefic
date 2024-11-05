<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Modal;
use yii\helpers\Html;

?>
<?php Modal::begin([
    'id' => 'modal-change-password',
    'title' => 'Reset Password',
    'size' => 'modal-lg',
]); ?>

<?php $form = ActiveForm::begin([
    'id' => 'form-change',
    'action' => 'forgot-password',
    'options' => []
])
?>
<?= $form->field($emailModel, 'email')->textInput(['maxlength' => true]) ?>
<div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-block']) ?>
</div>
<?php ActiveForm::end(); ?>
<?php Modal::end(); ?>