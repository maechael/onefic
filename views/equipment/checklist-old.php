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
        'widgetBody' => '.criteria-items', // required: css class selector
        'widgetItem' => '.criteria-item', // required: css class
        'limit' => 99, // the maximum times, an element can be cloned (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.add-criteria', // css class
        'deleteButton' => '.remove-criteria', // css class
        'model' => $grouped[42],
        'formId' => $form->id,
        // 'formId' => 'form-equipment-setup',
        'formFields' => [
            'equipment_id',
            'component_id',
        ],
    ]) ?>
    <div class="criteria-items">
        <?php foreach ($grouped as $i => $group) : ?>
            <div class="card card-info criteria-item">
                <div class="card-header">
                    <h3 class="card-title">Criteria</h3>
                    <div class="card-tools">
                        <button type="button" class="remove-criteria btn btn-light btn-tool">Remove</button>
                        <button type="button" class="add-criteria btn btn-light btn-tool">Add</button>
                    </div>
                </div>
                <div class="card-body">

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
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['para', ['ul', 'ol', 'paragraph']],
        ]
    };

    $('.textarea').summernote({
        height: textareaConfig.height,
        toolbar: textareaConfig.toolbar
    });

    $(".dynamicform_wrapper_component").on("afterInsert", function(e, item) {
        let textarea = $(item).find('.textarea');
        $(item).find('.hidden-equipment-id').val(equipment_id);
        textarea.summernote({
            height: textareaConfig.height,
            toolbar: textareaConfig.toolbar
        });
    });
JS);
