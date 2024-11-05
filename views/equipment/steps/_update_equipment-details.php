<?php

use app\models\Component;
use app\models\EquipmentComponentPart;
use app\models\TechService;
use kartik\file\FileInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kidzen\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model app\models\Equipment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="equipment-form">

    <?php $form = ActiveForm::begin([
        'id' => 'form-equipment',
        'options' => [
            'enctype' => 'multipart/form-data',
        ],
    ]); ?>

    <?= Html::activeHiddenInput($model, "isImageChanged", ['value' => 0]); ?>

    <div class="row">
        <div class="col-6">
            <?= $form->field($model, 'model')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'equipment_category_id')->widget(Select2::class, [
                'data' => ArrayHelper::map($categories, 'id', 'name'),
                //'size' => Select2::SMALL,
                'options' => ['placeholder' => 'Select a category...'],
                'pluginOptions' => [
                    'allowClear' => true
                ]
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <?= $form->field($model, 'equipment_type_id')->widget(Select2::class, [
                'data' => ArrayHelper::map($types, 'id', 'name'),
                //'size' => Select2::SMALL,
                'options' => ['placeholder' => 'Select a category...'],
                'pluginOptions' => [
                    'allowClear' => true
                ]
            ]) ?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'processing_capability_id')->widget(Select2::class, [
                'data' => ArrayHelper::map($processCapability, 'id', 'name'),
                //'size' => Select2::SMALL,
                'options' => ['placeholder' => 'Select a processing capability...'],
                'pluginOptions' => [
                    'allowClear' => true,
                ]
            ]) ?>
        </div>

    </div>

    <?= $form->field($model, 'techServiceIds')->widget(Select2::class, [
        // 'value' => $equipment->equipmentIds,
        'data' => ArrayHelper::map(TechService::getTechServices(), 'id', 'name'),
        'theme' => Select2::THEME_DEFAULT,
        'showToggleAll' => true,
        'options' => [
            'multiple' => true
        ],
        'pluginOptions' => [
            'allowClear' => true,
            'closeOnSelect' => false,
            'dropdownAutoWidth' => true,
            'width' => '100%',
            'scrollAfterSelect' => false,
            // 'templateResult' => new JsExpression("function(value){
            //     if (value && !value.selected) {
            //         return $('<span>' + value.text + '</span>');
            //     }
            // }")
        ]
    ]) ?>

    <?= $form->field($model, 'imageFile')->widget(FileInput::class, [
        // 'id' => 'imageFile',
        'name' => 'imageFile',
        'options' => [
            'id' => 'imageFile',
            'multiple' => false,
            'accept' => 'image/*',
            // 'accept' => 'application/pdf',
        ],
        'pluginOptions' => [
            $model->isNewRecord ? null :
                'initialPreview' => [
                isset($model->image) ? $model->image->link : null
            ],
            'initialCaption' => isset($model->image) ? $model->image->basename : '',
            'initialPreviewConfig' => isset($model->image) ? [
                ['caption' => $model->image->basename, 'size' => $model->image->size]
            ] : null,
            'initialPreviewAsData' => true,
            'overwriteInitial' => true,
            'allowedFileExtensions' => ['jpg', 'png'],
            'showUpload' => false,
            'showCancel' => false,
        ]
    ]); ?>

    <?php ActiveForm::end(); ?>
</div>
<?php
$this->registerJs(<<<JS
    let isImageChanged = $('#equipment-isimagechanged');

    // $('#imageFile').on('change', e => {
    //     console.log('image changed');
    // });

    $('#imageFile').on('fileclear', e => {
        isImageChanged.val('1');
    });

    $('#imageFile').on('filebatchselected', e => {
        isImageChanged.val('1');
    });
JS);
