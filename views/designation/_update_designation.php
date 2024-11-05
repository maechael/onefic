<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Modal;
use yii\helpers\Html;

?>

<div class="facility-form">
    <?php $form = ActiveForm::begin([
        'id' => 'form-update',
        'action' => "/designation/update?id={$model->id}",
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
                $('#modal-update-designation').modal('hide');           //..hides update modal
                yiiform.trigger('reset');    //..resets form
                swal({
                    title: 'Sucess',
                    text: 'Facility successfully created!',
                    type: "success"
                });               
                $.pjax.reload({container:'#designationGrid'}); //..reload gridview
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