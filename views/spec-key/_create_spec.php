<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Modal;

use yii\helpers\Html;

?>
<?php Modal::begin([
    'id' => 'modal-create-spec',
    'headerOptions' => ['class' => 'bg-primary'],
    'title' => 'Add Specification',
    'size' => 'modal-md',
    // 'toggleButton' => [
    //     'label' => 'Create Facility',
    //     'class' => 'btn btn-success btn-sm'
    // ],
]); ?>
<div class="spec-form">
    <?php $form = ActiveForm::begin([
        'id' => 'form-create',
        'action' => 'create',
        'options' => [
            // 'enctype' => 'multipart/form-data',
            //'data-pjax' => true
        ],
        'method' => 'POST',
    ]); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-block']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
<?php Modal::end();
$this->registerJs(<<<JS
    $('#form-create').on('beforeSubmit', function() {
        let yiiform = $(this);
        let formData = new FormData($('#form-create')[0]);

        // console.log(yiiform.yiiActiveForm('find', 'equipment-imagefile').value);
        $.ajax({
            type: yiiform.attr('method'),
            url: yiiform.attr('action'),
            processData: false,
            contentType: false,
            cache: false,
            // data: yiiform.serializeArray(),
            data: formData,
        }).done(data => {
            if(data.success){
                $('#modal-create-spec').modal('hide');           //..hides create modal
                yiiform.trigger('reset');                               //..resets form
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
