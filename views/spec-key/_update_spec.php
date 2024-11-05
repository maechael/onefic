<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;


?>
<div class="facility-form">
    <?php $form = ActiveForm::begin([
        'id' => 'form-update',
        'action' => "/spec-key/update?id={$model->id}",
        'options' => [
            //'data-pjax' => true
        ]
    ]); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

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
                $('#modal-update-spec').modal('hide');  //..hides update modal
                yiiform.trigger('reset');  //..resets form
                // swal({
                //     title: 'Sucess',
                //     text: 'Facility successfully created!',
                //     type: "success"
                // });                 
                $.pjax.reload({container:'#specGrid'}); //..reload gridview
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
