<?php

use kartik\editors\Summernote;
use kartik\switchinput\SwitchInput;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = $equipmentMaintenanceLog->equipment->model;

$currentEqCompId = 0;
?>
<?php $form = ActiveForm::begin(); ?>

<?php
if (!$equipmentMaintenanceLog->isNewRecord) {
    echo Html::activeHiddenInput($equipmentMaintenanceLog, 'id');
} ?>

<?= Html::activeHiddenInput($equipmentMaintenanceLog, 'fic_equipment_id') ?>

<?= $form->field($equipmentMaintenanceLog, 'maintenance_date')->input('date', ['class' => 'form-control']) ?>

<div class="row">
    <div class="col-6">
        <?= $form->field($equipmentMaintenanceLog, 'time_started')->input('time', ['class' => 'form-control']) ?>
    </div>
    <div class="col-6">
        <?= $form->field($equipmentMaintenanceLog, 'time_ended')->input('time', ['class' => 'form-control']) ?>
    </div>
</div>

<table class="table table-sm table-bordered table-hover">
    <thead class="text-center">
        <th></th>
        <th>Cleaned/Inspected</th>
        <th>Operational</th>
        <th>Remarks</th>
    </thead>
    <tbody>
        <?php foreach ($maintenanceLogComponentParts as $i => $logComponentPart) : ?>
            <?php if ($currentEqCompId != $logComponentPart->equipment_component_id) : ?>
                <?php $currentEqCompId = $logComponentPart->equipment_component_id; ?>
                <tr>
                    <td class="font-weight-bold" colspan="4"><?= $logComponentPart->component->name ?></td>
                </tr>
            <?php endif; ?>
            <?= Html::activeHiddenInput($maintenanceLogComponentParts[$i], "[{$i}]id") ?>
            <?= Html::activeHiddenInput($maintenanceLogComponentParts[$i], "[{$i}]equipment_maintenance_log_id") ?>
            <?= Html::activeHiddenInput($maintenanceLogComponentParts[$i], "[{$i}]equipment_component_id") ?>
            <?= Html::activeHiddenInput($maintenanceLogComponentParts[$i], "[{$i}]equipment_component_part_id") ?>
            <tr>
                <td class="align-middle pl-3">
                    <?= $logComponentPart->part->name ?>
                </td>
                <td class="text-center align-middle">
                    <?= $form->field($maintenanceLogComponentParts[$i], "[{$i}]isInspected")->widget(SwitchInput::class, [
                        'pluginOptions' => [
                            'size' => 'small',
                            'onText' => 'Yes',
                            'offText' => 'No',
                        ]
                    ])->label(false) ?>
                </td>
                <td class="text-center align-middle">
                    <?= $form->field($maintenanceLogComponentParts[$i], "[{$i}]isOperational")->widget(SwitchInput::class, [
                        'pluginOptions' => [
                            'size' => 'small',
                            'onText' => 'Yes',
                            'offText' => 'No',
                        ]
                    ])->label(false) ?>
                </td>
                <td class="align-middle"><?= $form->field($maintenanceLogComponentParts[$i], "[{$i}]remarks")->textInput(['class' => 'form-control form-control-sm'])->label(false) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="row">
    <div class="col-6">
        <?= $form->field($equipmentMaintenanceLog, 'inspected_checked_by')->textInput() ?>
    </div>
    <div class="col-6">
        <?= $form->field($equipmentMaintenanceLog, 'noted_by')->textInput() ?>
    </div>
</div>

<?= $form->field($equipmentMaintenanceLog, 'conclusion_recommendation')->widget(Summernote::class, [
    'useKrajeePresets' => true,
    'container' => [
        'class' => ''
    ]
]) ?>

<div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>