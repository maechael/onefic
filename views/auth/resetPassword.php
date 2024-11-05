<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\ResetPasswordForm $model */

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

$this->title = '';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reset-password d-flex align-content-center">
    <div class="flex-fill">
        <h1><?= Html::encode($this->title) ?></h1>
        <p><b>
                <h2>Reset your password</h2>
            </b></p>
        <p>Please choose your new password:</p>
        <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

        <div class="form-group">
            <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>
        </div>

        <div class="form-group">
            <?= $form->field($model, 'confirmNewPassword')->textInput(['maxlength' => true, 'class' => 'form-control', 'type' => 'password']) ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>