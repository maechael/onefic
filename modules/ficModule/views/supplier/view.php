<?php

use kartik\detail\DetailView;
use kartik\file\FileInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Supplier */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Suppliers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->organization_name;
\yii\web\YiiAsset::register($this);
?>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'group' => true,
            'label' => 'SUPPLIER INFORMATION',
            'rowOptions' => [
                'class' => 'table-info'
            ]
        ],
        ['attribute' => 'organization_name'],
        [
            'columns' => [
                ['attribute' => 'form_of_organization', 'valueColOptions' => ['style' => 'width:30%']],
                ['attribute' => 'certificate_ref_num', 'valueColOptions' => ['style' => 'width:30%']],
            ]
        ],
        [
            'columns' => [
                [
                    'attribute' => 'organization_status',
                    'value' => $model->getOrganizationStatus(),
                    'valueColOptions' => ['style' => 'width:30%']
                ],
                [
                    'attribute' => 'approval_status',
                    'value' => $model->getApprovalStatus(),
                    'valueColOptions' => ['style' => 'width:30%']
                ],
            ]
        ],
        [
            'group' => true,
            'label' => 'CONTACT INFORMATION',
            'rowOptions' => [
                'class' => 'table-info'
            ]
        ],
        [
            'columns' => [
                ['attribute' => 'contact_person', 'valueColOptions' => ['style' => 'width:30%'],],
                ['attribute' => 'email', 'valueColOptions' => ['style' => 'width:30%'],]
            ]
        ],
        [
            'columns' => [
                ['attribute' => 'cellNumber', 'valueColOptions' => ['style' => 'width:30%'],],
                ['attribute' => 'telNumber', 'valueColOptions' => ['style' => 'width:30%'],]
            ]
        ],
        [
            'group' => true,
            'label' => 'ADDRESS INFORMATION',
            'rowOptions' => [
                'class' => 'table-info'
            ]
        ],
        [
            'columns' => [
                ['attribute' => 'region', 'value' => $model->region->code, 'valueColOptions' => ['style' => 'width:30%'],],
                ['attribute' => 'municipalityCity', 'value' => $model->municipalityCity->name, 'valueColOptions' => ['style' => 'width:30%'],],
            ]
        ],
        [
            'columns' => [
                ['attribute' => 'province', 'value' => $model->province->name, 'valueColOptions' => ['style' => 'width:30%'],],
                ['attribute' => 'address', 'valueColOptions' => ['style' => 'width:30%'],],
            ]
        ],
    ],
    'mode' => DetailView::MODE_VIEW,
    'enableEditMode' => false,
    'bordered' => true,
    'striped' => false,
    'condensed' => false,
    'responsive' => true,
    'hover' => true,
    'hideIfEmpty' => false,
    'notSetIfEmpty' => true,
    'hAlign' => DetailView::ALIGN_RIGHT,
    'vAlign' => DetailView::ALIGN_MIDDLE,
    'panel' => [
        'type' => DetailView::TYPE_DARK,
        'heading' => "<i class='fas fa-boxes'></i> Supplier"
    ],
    'container' => [
        'id' => 'supplier-info-id'
    ]
]) ?>

<!-- Branches card -->
<?php if ($model->getBranches()->count() > 0) : ?>
    <div class="card">
        <div class="card-header text-white bg-dark">
            <h5 class="mb-0"><i class='fas fa-box'></i> Branches</h5>
        </div>
        <div class="card-body">
            <?php if ($model->getBranches()->count() == 0) : ?>
                <div class="alert alert-info" role="alert">
                    No registered branch.
                </div>
            <?php endif; ?>

            <div class="card-columns">
                <?php foreach ($model->branches as $branch) : ?>
                    <div class="card bg-light">
                        <div class="card-body">
                            <ul class="text-muted fa-ul">
                                <li class="small">
                                    <span class="fa-li"><i class="fas fa-map"></i></span><?= "{$branch->region->code} ({$branch->region->name}), {$branch->province->name} {$branch->municipalityCity->name}" ?>
                                </li>
                                <li class="small">
                                    <span class="fa-li"><i class="fas fa-map-marker-alt"></i></span><?= $branch->address ?>
                                </li>
                                <li class="small">
                                    <span class="fa-li"><i class="fas fa-mobile-alt"></i></span><?= !empty($branch->cellNumber) ? $branch->cellNumber : "-not provided-" ?>
                                </li>
                                <li class="small">
                                    <span class="fa-li"><i class="fas fa-envelope"></i></span><?= $branch->email ?>
                                </li>
                                <li class="small">
                                    <span class="fa-li"><i class="fas fa-phone"></i></span><?= !empty($branch->telNumber) ? $branch->telNumber : "-not provided-" ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Parts card -->
<?php if ($model->getParts()->count() > 0) : ?>
    <div class="card">
        <div class="card-header text-white bg-dark">
            <h5>* Term for: '<i>mga kaya nyang iprovide na parts</i>'</h5>
        </div>
        <div class="card-body">
            <div class="card-columns">
                <?php foreach ($model->parts as $part) : ?>
                    <div class="card bg-light">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="card-text"><?= $part->name ?></div>
                                <div class="d-flex">
                                    <?php foreach ($part->equipments as $equipment) : ?>
                                        <span class="badge badge-info p-1 m-1"><?= $equipment->model ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if ($model->getMedias()->count() > 0) : ?>
    <div class="card">
        <div class="card-header text-white bg-dark">
            <h5 class="mb-0"><i class='fas fa-folder-open'></i> Business Files</h5>
        </div>
        <div class="card-body">
            <?= FileInput::widget([
                'name' => 'businessFiles[]',
                'options' => [
                    'multiple' => true,
                    'accept' => '.pdf,image/*',
                ],
                'pluginOptions' => [
                    'showCancel' => false,
                    'showBrowse' => false,
                    'showRemove' => false,
                    'showClose' => false,
                    'inputGroupClass' => 'd-none',
                    'initialPreviewAsData' => true,
                    'initialPreviewShowDelete' => false,
                    'initialPreviewDownloadUrl' => false,
                    'overwriteInitial' =>  true,
                    'allowedFileExtensions' => ["pdf", "png", "jpg", "jpeg"],
                    'initialPreview' => $filePreviews,
                    'initialPreviewConfig' => $previewConfigs,
                ]
            ]); ?>
        </div>
    </div>
<?php endif; ?>