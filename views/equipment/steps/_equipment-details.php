<?php

use app\models\EquipmentCategory;
use app\models\EquipmentType;
use app\models\ProcessingCapability;
use app\models\TechService;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

?>
<div class="p-3">
    <div class="row">
        <div class="col-6">
            <?= $form->field($equipment, 'model')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-6">
            <?= $form->field($equipment, 'processing_capability_id')->widget(Select2::class, [
                'data' => ArrayHelper::map(ProcessingCapability::getProcessingCapabilities(), 'id', 'name'),
                //'size' => Select2::SMALL,
                'options' => ['placeholder' => 'Select a processing capability...'],
                'pluginOptions' => [
                    'allowClear' => true
                ]
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <?= $form->field($equipment, 'equipment_category_id')->widget(Select2::class, [
                'data' => ArrayHelper::map(EquipmentCategory::getEquipmentCategories(), 'id', 'name'),
                //'size' => Select2::SMALL,
                'changeOnReset' => true,
                'options' => ['placeholder' => 'Select a category...'],
                'pluginOptions' => [
                    'allowClear' => true
                ]
            ]) ?>
        </div>
        <div class="col-6">
            <?= $form->field($equipment, 'equipment_type_id')->widget(Select2::class, [
                'data' => ArrayHelper::map(EquipmentType::getEquipmentTypes(), 'id', 'name'),
                //'size' => Select2::SMALL,
                'changeOnReset' => true,
                'options' => ['placeholder' => 'Select a category...'],
                'pluginOptions' => [
                    'allowClear' => true
                ]
            ]) ?>

        </div>
    </div>

    <?= $form->field($equipment, 'techServiceIds')->widget(Select2::class, [
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

    <?= $form->field($equipment, 'imageFile')->widget(FileInput::class, [
        'name' => 'imageFile',
        'options' => [
            'multiple' => false,
            'accept' => 'image/*'
        ],
        'pluginOptions' => [
            'showUpload' => false,
            'showCancel' => false,
            'showClose' => false
        ]
    ]); ?>
</div>