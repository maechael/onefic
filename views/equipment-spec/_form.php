<?php

use app\models\SpecKey;
use kartik\select2\Select2;
use kidzen\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\EquipmentSpec */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="equipment-spec-form">

    <?php $form = ActiveForm::begin(
        ['id' => 'form-equipment-spec',]
    ); ?>

    <div class="row">
        <div class="col-12">
            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper1', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.spec-item', // required: css class
                'limit' => 20, // the maximum times, an element can be cloned (default 999)
                'min' => 0, // 0 or 1 (default 1)
                'insertButton' => '.add-spec', // css class
                'deleteButton' => '.remove-spec', // css class
                'model' => $equipmentSpecs[0],
                'formId' => 'form-equipment-spec',
                'formFields' => [
                    'spec_key_id',
                    'value'
                ],
            ]) ?>
            <div class="card">
                <div class="card-header">
                    <button type="button" class="add-spec btn btn-success btn-sm btn-block float-right"><i class="fas fa-plus"></i> Add</button>
                </div>
                <div class="card-body container-items">
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
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>