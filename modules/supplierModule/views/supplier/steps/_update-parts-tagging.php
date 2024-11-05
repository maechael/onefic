<?php

use app\models\Part;
use yii\helpers\ArrayHelper;

?>
<?= $form->field($supplier, 'partsField[]')->dropDownList(
    ArrayHelper::map(Part::getParts(), 'id', 'name'),
    [
        'class' => 'duallistbox',
        'multiple' => true,
        'value' => $supplier->partsField
    ]
)->label(false) ?>