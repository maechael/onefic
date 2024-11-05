<?php

use app\models\Component;
use app\models\EquipmentComponentPart;
use app\models\Part;
use kartik\select2\Select2;
use kidzen\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;

// var_dump($parts);
// die;
?>
<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrapper_part',
    'widgetBody' => '.container-parts',
    'widgetItem' => '.part-item',
    'limit' => 50,
    'min' => 0,
    'insertButton' => '.add-part',
    'deleteButton' => '.remove-part',
    'model' => $parts[0],
    'formId' => $form->id,
    // 'formId' => 'form-equipment-component-part',
    'formFields' => [
        'part_id'
    ],
]); ?>

<!-- <button type="button" class="add-part btn btn-success btn-sm btn-block float-right"><i class="fas fa-plus"></i> Add</button> -->
<table class="table table-sm table-borderless">
    <thead>
        <tr>
            <th></th>
            <th class="text-center">
                <button type="button" class="add-part btn btn-success btn-sm btn-block float-right"><i class="fas fa-plus"></i> Add</button>
            </th>
        </tr>
    </thead>
    <tbody class="container-parts">
        <?php foreach ($parts as $indexPart => $part) : ?>
            <tr class="part-item">
                <td class="align-middle">
                    <?= $form->field($part, "[{$indexComponent}][{$indexPart}]part_id")->widget(Select2::class, [
                        'data' => ArrayHelper::map(Part::getParts(), 'id', 'name'),
                        'size' => Select2::SMALL,
                        'options' => ['placeholder' => 'Select a part...'],
                        'pluginOptions' => [
                            //'allowClear' => true
                        ]
                    ])->label(false) ?>
                </td>
                <td class="align-middle"><button type="button" class="remove-part btn btn-danger btn-sm btn-block mb-1">Remove</button></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php DynamicFormWidget::end(); ?>