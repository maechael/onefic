<?php

use app\assets\DualListBoxAsset;
use app\assets\SmartWizardAsset;
use app\models\Branch;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

SmartWizardAsset::register($this);
DualListBoxAsset::register($this);

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Supplier', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Supplier Setup'];
?>
<?php $form = ActiveForm::begin([
    'id' => 'form-supplier-setup',
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
                Supplier Details
            </a>
        </li>
        <li class="nav-item">
            <a href="#step-2" class="nav-link">
                <span class="num">2</span>
                Branches
            </a>
        </li>
        <li class="nav-item">
            <a href="#step-3" class="nav-link">
                <span class="num">3</span>
                Parts Tagging
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div id='step-1' class="tab-pane">
            <?= $this->render('steps/_create_supplier-details', [
                'form' => $form,
                'supplier' => $supplier
            ]) ?>
        </div>
        <div id='step-2' class="tab-pane">
            <?= $this->render('steps/_create_branches', [
                'form' => $form,
                'branches' => $branches
            ]) ?>
        </div>
        <div id='step-3' class="tab-pane">
            <?= $this->render('steps/_create_parts-tagging', [
                'form' => $form,
                'supplier' => $supplier
            ]) ?>
        </div>
    </div>
    <div class="progress">
        <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<?php
$this->registerJs($this->render('js/_script.js'));
