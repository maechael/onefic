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
    'id' => 'modal-create-equipment',
    'title' => 'Add Equipment',
    'size' => 'modal-lg',
    // 'toggleButton' => [
    //     'label' => 'Create Facility',
    //     'class' => 'btn btn-success btn-sm'
    // ],
]); ?>

<div class="facility-form">
    <?php $form = ActiveForm::begin([
        'id' => 'form-create',
        'action' => 'create',
        'options' => [
            'enctype' => 'multipart/form-data',
            //'data-pjax' => true
        ],
        'method' => 'POST',
    ]); ?>

    <?= $form->field($equipment, 'model')->textInput(['maxlength' => true]) ?>

    <?= $form->field($equipment, 'equipment_category_id')->widget(Select2::class, [
        'data' => ArrayHelper::map(EquipmentCategory::getEquipmentCategories(), 'id', 'name'),
        //'size' => Select2::SMALL,
        'changeOnReset' => true,
        'options' => ['placeholder' => 'Select a category...'],
        'pluginOptions' => [
            'allowClear' => true
        ]
    ]) ?>

    <?= $form->field($equipment, 'equipment_type_id')->widget(Select2::class, [
        'data' => ArrayHelper::map(EquipmentType::getEquipmentTypes(), 'id', 'name'),
        //'size' => Select2::SMALL,
        'changeOnReset' => true,
        'options' => ['placeholder' => 'Select a category...'],
        'pluginOptions' => [
            'allowClear' => true
        ]
    ]) ?>

    <?= $form->field($equipment, 'processing_capability_id')->widget(Select2::class, [
        'data' => ArrayHelper::map(ProcessingCapability::getProcessingCapabilities(), 'id', 'name'),
        //'size' => Select2::SMALL,
        'options' => ['placeholder' => 'Select a processing capability...'],
        'pluginOptions' => [
            'allowClear' => true
        ]
    ]) ?>

    <?= $form->field($equipment, 'imageFile')->widget(FileInput::className(), [
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
                $('#modal-create-equipment').modal('hide');           //..hides create modal
                yiiform.trigger('reset');                               //..resets form
                // swal({
                //     title: 'Sucess',
                //     text: 'Facility successfully created!',
                //     type: "success"
                // });
                $.pjax.reload({container:'#equipmentGrid'}); //..reload gridview
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
