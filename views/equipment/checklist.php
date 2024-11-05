<?php

// use kartik\editors\Summernote;

use app\models\EquipmentComponent;
use kartik\editors\assets\SummernoteAsset;
use kartik\file\FileInput;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use kidzen\dynamicform\DynamicFormWidget;
use yii\bootstrap4\Html;
use yii\helpers\ArrayHelper;
use yii\web\View;

SummernoteAsset::register($this);

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Equipments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $equipment->model, 'url' => ['view', 'id' => $equipment->id]];
$this->params['breadcrumbs'][] = 'Maintenance Checklist';

?>
<div class="checklist-view">
    <?php $form = ActiveForm::begin([
        'id' => 'form-checklist',
        'options' => [
            'enctype' => 'multipart/form-data',
        ],
    ]); ?>
    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper_component', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.component-items', // required: css class selector
        'widgetItem' => '.component-item', // required: css class
        'limit' => 99, // the maximum times, an element can be cloned (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.add-component', // css class
        'deleteButton' => '.remove-component', // css class
        'model' => $checklistComponents[0],
        'formId' => $form->id,
        // 'formId' => 'form-equipment-setup',
        'formFields' => [
            'equipment_id',
            'component_id',
        ],
    ]) ?>
    <div class="component-items">
        <?php foreach ($checklistComponents as $i => $component) : ?>
            <div class="card card-info component-item">
                <div class="card-header">
                    <h3 class="card-title">Criteria</h3>
                    <div class="card-tools">
                        <button type="button" class="remove-component btn btn-light btn-tool">Remove</button>
                        <button type="button" class="add-component btn btn-light btn-tool">Add</button>
                    </div>
                </div>
                <div class="card-body">
                    <?php
                    if ($component->isNewRecord)
                        echo Html::activeHiddenInput($component, "[{$i}]id");
                    ?>

                    <?= Html::activeHiddenInput($component, "[{$i}]equipment_id", ['value' => $equipment->id, 'class' => 'hidden-equipment-id']) ?>

                    <?= $form->field($component, "[{$i}]equipment_component_id")->widget(Select2::class, [
                        'data' => ArrayHelper::map(EquipmentComponent::getEquipmentComponents($equipment->id), 'id', function ($item) {
                            return $item->component->name;
                        }),
                        'options' => ['placeholder' => 'Select a component...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ]
                    ]) ?>

                    <?= $this->render('_criteria', [
                        'form' => $form,
                        'i' => $i,
                        'criteriaTemplates' => $criteriaTemplates[$i]
                    ]) ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php DynamicFormWidget::end(); ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php
$this->registerJsVar('equipment_id', $equipment->id);
$this->registerJs(<<<JS
    var textareaConfig = {
        height: 200,
        lineHeight: 1.0,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
        ]
    };

    $('.textarea').summernote({
        height: textareaConfig.height,
        lineHeight: textareaConfig.lineHeight,
        toolbar: textareaConfig.toolbar
    });

    $(".dynamicform_wrapper_component").on("afterInsert", function(e, item) {
        let textarea = $(item).find('.textarea');
        $(item).find('.hidden-equipment-id').val(equipment_id);
        textarea.summernote({
            height: textareaConfig.height,
            lineHeight: textareaConfig.lineHeight,
            toolbar: textareaConfig.toolbar
        });

        $(item).find('.dynamicform_wrapper_component1').on('afterInsert', function(e, item){
            let textarea = $(item).find('.textarea');
            textarea.summernote({
                height: textareaConfig.height,
                lineHeight: textareaConfig.lineHeight,
                toolbar: textareaConfig.toolbar
            });
        });
    });
JS);
