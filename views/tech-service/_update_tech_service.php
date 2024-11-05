<?php

use kartik\editors\Summernote;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

?>
<div class="tech-service-form">
    <?php $form = ActiveForm::begin([
        'id' => 'form-update',
        'action' => "/tech-service/update?id={$model->id}",
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
                $('#modal-update-tech-service').modal('hide');           //..hides update modal
                yiiform.trigger('reset');                   //..resets form
                // $.pjax.reload({container:'#partGrid'}); //..reload gridview
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
