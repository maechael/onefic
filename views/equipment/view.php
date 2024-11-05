<?php

use app\models\EquipmentCategory;
use app\models\EquipmentType;
use app\models\FicEquipment;
use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\Equipment */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Equipments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->model;
\yii\web\YiiAsset::register($this);
$attributes = [
    'model',
    [
        'columns' => [
            [
                'attribute' => 'equipment_type_id',
                'value' => $model->equipmentType->name,
                'type' => DetailView::INPUT_SELECT2,
                'widgetOptions' => [
                    'data' => ArrayHelper::map(EquipmentType::getEquipmentTypes(), 'id', 'name'),
                    'options' => [
                        'placeholder' => 'Select equipment type...'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ]
                ],
                'updateAttr' => 'equipment_type_id'
            ],
            [
                'attribute' => 'equipment_category_id',
                'value' => $model->equipmentCategory->name,
                'type' => DetailView::INPUT_SELECT2,
                'widgetOptions' => [
                    'data' => ArrayHelper::map(EquipmentCategory::getEquipmentCategories(), 'id', 'name'),
                    'options' => [
                        'placeholder' => 'Select equipment category...'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ]
                ],
                'updateAttr' => 'equipment_category_id'
            ],
        ],
    ],
    [
        'attribute' => 'created_at',
        'displayOnly' => true
    ],
    [
        'attribute' => 'updated_at',
        'displayOnly' => true
    ]
];
?>
<div class="equipment-view">
    <div class="row">
        <div class="col-md-3">
            <!-- Profile Pic Card -->
            <div class="card card-primary card-outline">
                <!-- <div class="card-header">
                    <h3 class="profile-username text-center"><?= $model->model ?></h3>
                </div> -->
                <div class="card-body box-profile">
                    <?= Html::img(isset($model->image) ? $model->image->link : "", ['class' => 'img-fluid pad rounded', 'alt' => $model->model]) ?>
                    <h3 class="profile-username text-center"><?= $model->model ?></h3>
                    <hr>
                    <strong><i class="fas fa-sitemap mr-1"></i> Equipment Category</strong>
                    <p class="text-muted">
                        <?= $model->equipmentCategory->name ?>
                    </p>
                    <hr>
                    <strong><i class="fas fa-industry mr-1"></i> Equipment Type</strong>
                    <p class="text-muted"><?= $model->equipmentType->name ?></p>
                    <hr>
                    <div class="d-flex">
                        <?= Html::a('<i class="fas fa-edit"></i> Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm btn-block m-1']) ?>
                        <?= Html::a('<i class="fas fa-trash"></i> Delete', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger btn-sm btn-block m-1',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </div>
                    <div class="d-flex">
                        <?= Html::a('<i class="fas fa-edit"></i>Component-Part', ['component-part-update', 'id' => $model->id], ['class' => 'btn btn-info btn-sm btn-block m-1']) ?>
                        <?= Html::a('<i class="fas fa-edit"></i>Update Specs', ['equipment-spec/update', 'id' => $model->id], ['class' => 'btn btn-info btn-sm btn-block m-1']) ?>
                    </div>
                </div>
            </div>
            <!-- Profile Pic Card End -->
        </div>

        <div class="col-9">
            <div class="card card-primary card-outline card-outline-tabs">
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a href="#tab-content-specification" class="nav-link active" data-toggle="pill" role="tab">Specification</a>
                        </li>
                        <li class="nav-item">
                            <a href="#tab-content-component" class="nav-link" data-toggle="pill" role="tab">Components & Parts</a>
                        </li>
                        <li class="nav-item">
                            <a href="#tab-content-tech-service" class="nav-link" data-toggle="pill" role="tab">Tech Service</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="tab-content-specification">
                            <?php if (isset($model->equipmentSpecs) && $model->getEquipmentSpecs()->count() > 0) : ?>
                                <div class="d-flex flex-wrap">
                                    <?php foreach ($model->equipmentSpecs as $spec) : ?>
                                        <table class="table table-bordered m-0">
                                            <tr>
                                                <td class="table-secondary col-3"><?= $spec->specKey->name ?></td>
                                                <td><?= $spec->value ?></td>
                                            </tr>
                                        </table>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="tab-pane fade" id="tab-content-component">
                            <div class="card-columns">
                                <?php foreach ($model->equipmentComponents as $component) : ?>
                                    <div class="card">
                                        <div class="card-header text-center bg-light"><?= $component->component->name ?></div>
                                        <ul class="list-group list-group-flush">
                                            <?php foreach ($component->equipmentComponentParts as $part) : ?>
                                                <li class="list-group-item d-flex">
                                                    <?= $part->part->name ?>
                                                    <!-- <span class="badge ml-auto">operational</span> -->
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="tab-content-tech-service">
                            <?php foreach ($model->techServices as $techService) : ?>
                                <button class="btn btn-info"><?= $techService->name ?></button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>