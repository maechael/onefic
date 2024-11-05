<?php

use kidzen\dynamicform\DynamicFormWidget;
use yii\bootstrap4\Html;

?>
<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrapper_component1', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
    'widgetBody' => '.criteria-items', // required: css class selector
    'widgetItem' => '.criteria-item', // required: css class
    'limit' => 99, // the maximum times, an element can be cloned (default 999)
    'min' => 1, // 0 or 1 (default 1)
    'insertButton' => '.add-criteria', // css class
    'deleteButton' => '.remove-criteria', // css class
    'model' => $criteriaTemplates[0],
    'formId' => $form->id,
    // 'formId' => 'form-equipment-setup',
    'formFields' => [
        'equipment_id',
        'component_id',
    ],
]) ?>
<div class="criteria-items">
    <?php foreach ($criteriaTemplates as $j => $criteria) : ?>
        <div class="criteria-item">
            <div class="float-right">
                <button type="button" class="remove-criteria btn btn-light btn-tool">Remove</button>
                <button type="button" class="add-criteria btn btn-light btn-tool">Add</button>
            </div>
            <?php
            if ($criteria->isNewRecord)
                echo Html::activeHiddenInput($criteria, "[{$i}][{$j}]id");
            ?>
            <?= $form->field($criteria, "[{$i}][{$j}]description")->textarea([
                'class' => 'textarea',
                'rows' => 5
            ])->label("Criteria") ?>
        </div>
    <?php endforeach; ?>
</div>
<?php DynamicFormWidget::end(); ?>
<?php
$this->registerJs(<<<JS
    $('.dynamicform_wrapper_component1').on('afterInsert', function(e, item) {
        let textarea = $(item).find('.textarea');
        textarea.summernote({
            height: textareaConfig.height,
            lineHeight: textareaConfig.lineHeight,
            toolbar: textareaConfig.toolbar
        });
    });
JS);
