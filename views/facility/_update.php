<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\modal;
use yii\helpers\Html;

?>

<div class="facility-form">
    <?php $form = ActiveForm::begin([
        'id' => 'form-update',
        'action' => "/facility/update?id={$facility->id}",
        'options' => [
            //'data-pjax' => true
        ]
    ]); ?>
    <?= $form->field($facility, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($facility, 'description')->textarea(['rows' => 6]) ?>

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
                $('#modal-update').modal('hide'); //..hides update modals
                yiiform.trigger('reset');    //..resets form
                swal({
                    title: 'Sucess',
                    text: 'Facility successfully created!',
                    type: "success"
                });
                $.pjax.reload({container:'#facilityGrid'});//..reload gridview
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
