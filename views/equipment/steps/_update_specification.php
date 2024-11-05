<?php

use app\models\SpecKey;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use kidzen\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

?>


<div class="p-3">
    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper_spec', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-specs', // required: css class selector
        'widgetItem' => '.spec-item', // required: css class
        'limit' => 20, // the maximum times, an element can be cloned (default 999)
        'min' => 0, // 0 or 1 (default 1)
        'insertButton' => '.add-spec', // css class
        'deleteButton' => '.remove-spec', // css class
        'model' => $equipmentSpecs[0],
        'formId' => $form->id,
        'formFields' => [
            'equipment_id',
            'component_id',
            'spec_key_id',
        ],
    ]) ?>
    <div class="card">
        <div class="card-header">
            <button type="button" class="add-spec btn btn-success btn-sm btn-block float-right"><i class="fas fa-plus"></i> Add</button>
        </div>
        <div class="card-body container-specs">
            <?php foreach ($equipmentSpecs as $i => $spec) : ?>
                <div class="form-row spec-item">
                    <?php
                    if (!$spec->isNewRecord) {
                        echo Html::activeHiddenInput($spec, "[{$i}]id");
                    } ?>
                    <?= Html::activeHiddenInput($spec, "[{$i}]equipment_id") ?>
                    <div class="col">
                        <?= $form->field($spec, "[{$i}]spec_key_id")->widget(Select2::class, [
                            'data' => ArrayHelper::map(SpecKey::getSpecKeys(), 'id', 'name'),
                            // 'size' => Select2::SMALL,
                            'options' => ['placeholder' => 'Select a spec...'],
                            'pluginOptions' => [
                                //'allowClear' => true
                            ]
                        ]) ?>
                    </div>
                    <div class="col">
                        <?= $form->field($spec, "[{$i}]value")->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col">
                        <button type="button" class="remove-spec btn btn-danger btn-sm btn-block mb-1">Remove</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php DynamicFormWidget::end(); ?>
</div>