<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap4\modal;

?>

<div class="facility-form">
    <?php $form = ActiveForm::begin([
        'id' => 'form-update',
        'action' => "/service/update?id={$model->id}",
        'options' => [
            //'data-pjax' => true
        ]
    ]); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

     <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<?php
$this->registerJs(<<<JS
    $('body').on('beforeSubmit', '#form-update', function() {
        let yiiform = $(this);

        $.ajax({
            type: yiiform.attr('method'),
            url: yiiform.attr('action'),
            data: yiiform.serializeArray(),
        }).done(data => {
            if(data.success){
                $('#modal-update-service').modal('hide');           //..hides update modal
                yiiform.trigger('reset');                   //..resets form
                $.pjax.reload({container:'#serviceGrid'}); //..reload gridview
            } else if (data.validation) {
                yiiform.yiiActiveForm('updateMessages', data.validation, true);
            } else {
                // incorrect server response
            }
        }).fail(() => {
            // request failed
        });

        return false;
    });
JS);
