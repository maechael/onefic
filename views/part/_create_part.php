<?php

use app\models\Equipment;
use app\models\EquipmentCategory;
use app\models\EquipmentType;
use app\models\ProcessingCapability;
use app\modules\ficModule\models\FicEquipment;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>
<?php Modal::begin([
    'id' => 'modal-create-part',
    'headerOptions' => ['class' => 'bg-primary'],
    'title' => 'Add Part',
    'size' => 'modal-lg',
    // 'toggleButton' => [
    //     'label' => 'Create Facility',
    //     'class' => 'btn btn-success btn-sm'
    // ],
]); ?>

<div class="part-form">
    <?php $form = ActiveForm::begin([
        'id' => 'form-create',
        'action' => 'create',
        'options' => [
            // 'enctype' => 'multipart/form-data',
            //'data-pjax' => true
        ],
        'method' => 'POST',
    ]); ?>

    <?= $form->field($part, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($part, 'imageFile')->widget(FileInput::className(), [
        'name' => 'imageFile',
        'options' => [
            'multiple' => false,
            'accept' => 'image/*'
        ],
        'pluginOptions' => [
            'showUpload' => false
        ]
    ]); ?>

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
                $('#modal-create-part').modal('hide');           //..hides create modal
                yiiform.trigger('reset');                               //..resets form
                // swal({
                //     title: 'Sucess',
                //     text: 'Facility successfully created!',
                //     type: "success"
                // });
                $.pjax.reload({container:'#partGrid'}); //..reload gridview
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
