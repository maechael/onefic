<?php

use app\models\SpecKey;
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
            // 'equipment_id',
            'component_id',
            'spec_key_id',
        ],
    ]) ?>
    <div class="card card-outline card-primary">
        <!-- <div class="card-header">
            <button type="button" class="add-spec btn btn-info btn-sm float-right"><i class="fas fa-plus"></i> Add</button>
        </div> -->
        <div class="card-body">
            <button type="button" class="add-spec btn btn-info btn-sm float-right mb-1"><i class="fas fa-plus"></i> Add</button>
            <table class="table">
                <thead class="thead-light text-center">
                    <th class="">Specification</th>
                    <th class="">Value</th>
                    <th class=""></th>
                </thead>
                <tbody class="container-specs">
                    <?php foreach ($equipmentSpecs as $i => $spec) : ?>
                        <?php
                        if (!$spec->isNewRecord) {
                            echo Html::activeHiddenInput($spec, "[{$i}]id");
                        } ?>
                        <tr class="spec-item">
                            <?= Html::activeHiddenInput($spec, "[{$i}]equipment_id") ?>
                            <td class="align-middle">
                                <?= $form->field($spec, "[{$i}]spec_key_id")->widget(Select2::class, [
                                    'data' => ArrayHelper::map(SpecKey::getSpecKeys(), 'id', 'name'),
                                    // 'size' => Select2::SMALL,
                                    'options' => ['placeholder' => 'Select a spec...'],
                                    'pluginOptions' => [
                                        //'allowClear' => true
                                    ]
                                ])->label(false) ?>
                            </td>
                            <td class="align-middle">
                                <?= $form->field($spec, "[{$i}]value")->textInput(['maxlength' => true])->label(false) ?>
                            </td>
                            <td class="align-middle">
                                <button type="button" class="remove-spec btn btn-info btn-sm btn-block mb-1">Remove</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>


        </div>
    </div>
    <?php DynamicFormWidget::end(); ?>
</div>