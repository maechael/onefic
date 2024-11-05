<?php

use kartik\editors\Summernote;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Modal;
use yii\helpers\Html;

?>

<?php Modal::begin([
    'id' => 'modal-create-component',
    'headerOptions' => ['class' => 'bg-primary'],
    'title' => 'Add Component',
    'size' => 'modal-lg',
]); ?>

<div class="component-form">
    <?php $form = ActiveForm::begin([
        'id' => 'form-create',
        'action' => 'create',
        'options' => [],
        'method' => 'POST',
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->widget(Summernote::class, [
        'useKrajeePresets' => true,
        'container' => [
            'class' => ''
        ]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<?php Modal::end(); ?>
<?php
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
                $('#modal-create-component').modal('hide');           //..hides create modal
                yiiform.trigger('reset');                               //..resets form
                $.pjax.reload({container:'#componentGrid'}); //..reload gridview
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
