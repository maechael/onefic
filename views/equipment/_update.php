<?php

use app\assets\DualListBoxAsset;
use app\assets\SmartWizardAsset;
use app\models\Branch;
use app\models\EquipmentComponent;
use app\models\EquipmentSpec;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

SmartWizardAsset::register($this);
DualListBoxAsset::register($this);

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Equipment', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Equipment'];
?>
<?php $form = ActiveForm::begin([
    'id' => 'form-equipment-setup',
    'options' => [
        'enctype' => 'multipart/form-data',
    ],
    'method' => 'POST',
]); ?>
<div id="smartwizard">
    <ul class="nav">
        <li class="nav-item">
            <a href="#step-1" class="nav-link">
                <div class="num">1</div>
                Equipment Details
            </a>
        </li>
        <li class="nav-item">
            <a href="#step-2" class="nav-link">
                <span class="num">2</span>
                Component/parts
            </a>
        </li>
        <li class="nav-item">
            <a href="#step-3" class="nav-link">
                <span class="num">3</span>
                Specification
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div id='step-1' class="tab-pane">
            <?= $this->render('steps/_update_equipment-details', [
                'form' => $form,
                'model' => $equipment,
                'categories' => $categories,
                'types' => $types,
                'processCapability' => $processCapability,

            ]) ?>
        </div>
        <div id='step-2' class="tab-pane">
            <?= $this->render('steps/_update_component-part', [
                'form' => $form,
                'components' => $components,
                'model' => $equipment,
                'part' => $part,

            ]) ?>
        </div>
        <div id='step-3' class="tab-pane">
            <?= $this->render('steps/_update_specification.php', [
                'form' => $form,
                'equipmentSpecs' => $equipmentSpecs
            ]) ?>
        </div>
    </div>
    <div class="progress">
        <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<?php
$this->registerJs($this->render('js/_update_script.js'));
