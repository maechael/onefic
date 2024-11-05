<?php

use app\assets\FilterMultiSelectAsset;
use app\models\Component;
use app\models\EquipmentComponentPart;
use app\models\Part;
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
    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper_component', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items', // required: css class selector
        'widgetItem' => '.component-item', // required: css class
        'limit' => 20, // the maximum times, an element can be cloned (default 999)
        'min' => 0, // 0 or 1 (default 1)
        'insertButton' => '.add-component', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $components[0],
        'formId' => $form->id,
        'formFields' => [
            'equipment_id',
            'component_id',
        ],
    ]);
    ?>
    <div class="container-items">
        <?php foreach ($components as $i => $component) : ?>
            <div class="card card-info component-item w-100">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-cog header-icon"></i> Component & Parts</h3>
                    <div class="card-tools">
                        <button type="button" class="remove-item btn btn-light btn-tool">Remove</button>
                        <button type="button" class="add-component btn btn-light btn-tool">Add</button>
                    </div>
                </div>
                <div class="card-body">
                    <?php
                    if (!$component->isNewRecord) {
                        echo Html::activeHiddenInput($component, "[{$i}]id");
                    } ?>

                    <?= Html::activeHiddenInput($component, "[{$i}]equipment_id") ?>
                    <?= $form->field($component, "[{$i}]component_id")->widget(Select2::class, [
                        'data' => ArrayHelper::map(Component::getComponents(), 'id', 'name'),
                        'size' => Select2::SMALL,
                        'options' => ['placeholder' => 'Select a component...'],
                        'pluginOptions' => [
                            //'allowClear' => true
                        ]
                    ]) ?>

                    <?= $form->field($component, "[{$i}]parts")->widget(Select2::class, [
                        'data' => ArrayHelper::map(Part::getParts(), 'id', 'name'),
                        'theme' => Select2::THEME_DEFAULT,
                        'showToggleAll' => true,
                        // 'hideSearch' => true,
                        'options' => [
                            'placeholder' => 'Select parts ...',
                            'multiple' => true,
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'closeOnSelect' => false,
                            // 'dropdownAutoWidth' => true,
                            'width' => '100%',
                        ],
                    ]); ?>

                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php DynamicFormWidget::end(); ?>

</div>