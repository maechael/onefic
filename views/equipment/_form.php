<?php

use app\models\Component;
use app\models\EquipmentComponentPart;
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
        <div class="col-12">
            <?= $form->field($model, 'model')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'equipment_category_id')->widget(Select2::class, [
                'data' => ArrayHelper::map($categories, 'id', 'name'),
                //'size' => Select2::SMALL,
                'options' => ['placeholder' => 'Select a category...'],
                'pluginOptions' => [
                    'allowClear' => true
                ]
            ]) ?>

            <?= $form->field($model, 'equipment_type_id')->widget(Select2::class, [
                'data' => ArrayHelper::map($types, 'id', 'name'),
                //'size' => Select2::SMALL,
                'options' => ['placeholder' => 'Select a category...'],
                'pluginOptions' => [
                    'allowClear' => true
                ]
            ]) ?>

            <?= $form->field($model, 'processing_capability_id')->widget(Select2::class, [
                'data' => ArrayHelper::map($processCapability, 'id', 'name'),
                //'size' => Select2::SMALL,
                'options' => ['placeholder' => 'Select a processing capability...'],
                'pluginOptions' => [
                    'allowClear' => true,
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
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

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
