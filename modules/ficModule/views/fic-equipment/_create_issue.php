<?php

use kartik\editors\Summernote;
use kartik\file\FileInput;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>
<?php Modal::begin([
    'id' => 'modal-create',
    'title' => 'Create Issue',
    'size' => 'modal-lg',
]); ?>

<div class="facility-form">
    <?php $form = ActiveForm::begin([
        'id' => 'form-create',
        'action' => 'create-issue',
        'options' => [
            'enctype' => 'multipart/form-data',
            //'data-pjax' => true
        ]
    ]); ?>

    <?= $form->field($issue, 'fic_equipment_id')->hiddenInput(['value' => $fic_equipment_id])->label(false) ?>

    <?= $form->field($issue, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($issue, 'description')->widget(Summernote::class, [
        'useKrajeePresets' => true,
        'container' => [
            'class' => ''
        ]
    ]) ?>

    <?= $form->field($issue, 'imageFile')->widget(FileInput::class, [
        'name' => 'imageFile',
        'options' => [
            'multiple' => false,
            'accept' => 'image/*'
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php Modal::end();

$this->registerJs(<<<JS
    $('#form-create').on('beforeSubmit', function() {
        let yiiform = $(this);
        let test = yiiform.serialize();

        $.ajax({
            type: yiiform.attr('method'),
            url: yiiform.attr('action'),
            data: yiiform.serializeArray(),
        }).done(data => {
            if(data.success){
                $('#modal-create').modal('hide');           //..hides create modal
                yiiform.trigger('reset');                   //..resets form
                // swal({
                //     title: 'Sucess',
                //     text: 'Facility successfully created!',
                //     type: "success"
                // });
                $.pjax.reload({container:'#issues-pjax'}); //..reload gridview
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
