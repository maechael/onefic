<?php

use yii\helpers\Html;
use dominus77\sweetalert2\Alert;

Alert::widget(['useSessionFlash' => true]);
?>
<div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'login-form']) ?>

        <?= $form->field($model, 'username', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div>',
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
            'wrapperOptions' => ['class' => 'input-group mb-3']
        ])
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

        <?= $form->field($model, 'password', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-eye" id="spanEye"></span></div></div>',
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
            'wrapperOptions' => ['class' => 'input-group mb-3']
        ])
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

        <div class="row">
            <div class="col-8">
                <?= $form->field($model, 'rememberMe')->checkbox([
                    'template' => '<div class="icheck-primary">{input}{label}</div>',
                    'labelOptions' => [
                        'class' => ''
                    ],
                    'uncheck' => null
                ]) ?>
            </div>
            <div class="col-4">
                <?= Html::submitButton('Sign In', ['class' => 'btn btn-primary btn-block']) ?>
            </div>
        </div>

        <?php \yii\bootstrap4\ActiveForm::end(); ?>

        <p class="mb-1">
            <?= Html::a('I forgot my password', '#', ['data-toggle' => 'modal', 'data-target' => '#modal-change-password']) ?>
        </p>
    </div>
    <!-- /.login-card-body -->
</div>

<?= $this->render('_forgot-password-email', [
    'emailModel' => $emailModel
]); ?>
<?php
$this->registerJs(<<<JS
$('.input-group-text').on('click', function(){
    var passField = $('#loginform-password');
    var passwordFieldType = passField.attr('type');
    if(passwordFieldType == 'password'){
        passField.attr('type', 'text');
        $('#spanEye').removeClass('fa-eye').addClass('fa-eye-slash');
    }else{
        passField.attr('type', 'password');
         $('#spanEye').removeClass('fa-eye-slash').addClass('fa-eye');

    }
});
JS)


?>