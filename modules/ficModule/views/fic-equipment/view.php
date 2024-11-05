<?php

use app\modules\ficModule\models\FicEquipment;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\ficModule\models\FicEquipment */

$this->title = $model->equipment->model;
$this->params['breadcrumbs'][] = ['label' => 'Fic Equipments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="row">

    <!-- Left Side -->
    <div class="col-md-3">

        <!-- Profile Pic Card -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">

                <?= Html::img(isset($model->equipment->image) ? $model->equipment->image->link : "", ['class' => 'img-fluid pad rounded', 'alt' => $model->equipment->model]) ?>

                <h3 class="profile-username text-center"><?= $model->equipment->model ?></h3>
                <p class="text-muted text-center"><?= $model->serial_number ?></p>

                <hr>
                <strong><i class="fas fa-sitemap mr-1"></i> Equipment Category</strong>
                <p class="text-muted">
                    <?= $model->equipment->equipmentCategory->name ?>
                </p>

                <hr>

                <strong><i class="fas fa-industry mr-1"></i> Equipment Type</strong>
                <p class="text-muted"><?= $model->equipment->equipmentType->name ?></p>

                <hr>

                <strong><i class="fas fa-temperature-low mr-1"></i> Equipment Status</strong>
                <p class="text-muted"><?= $model->status == FicEquipment::STATUS_SERVICEABLE ? "Serviceable" : "Unserviceable" ?></p>

                <hr>

                <div class="d-flex">
                    <?= Html::a('<i class="fas fa-edit"></i> Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary flex-fill']) ?>
                    <?= Html::a('<i class="fas fa-trash"></i> Delete', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger flex-fill ml-1',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </div>

            </div>
        </div>
        <!-- Profile Pic Card End -->

    </div>
    <!-- Left Side End -->

    <!-- Right Side -->
    <div class="col-md-9">
        <div class="row">
            <div class="col-4">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?= $model->issueCount ?></h3>
                        <p>Issues</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-clipboard"></i>
                    </div>
                    <?= Html::a('More info <i class="fas fa-arrow-circle-right"></i>', ['issues', 'fic_equipment_id' => $model->id], ['class' => 'small-box-footer']) ?>
                </div>
            </div>

            <div class="col-4">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?= isset($model->latestMaintenanceLog) ? $model->latestMaintenanceLog->maintenance_date : "0000-00-00" ?></h3>
                        <p>Maintenance Log</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-tools"></i>
                    </div>
                    <?= Html::a('More info <i class="fas fa-arrow-circle-right"></i>', Url::to(['equipment-maintenance-log/maintenance-list', 'fic_equipment_id' => $model->id]), ['class' => 'small-box-footer']) ?>
                </div>
            </div>

            <div class="col-4">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>5</h3>
                        <p>Activity Log</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <?= Html::a('More info <i class="fas fa-arrow-circle-right"></i>', ['issues', 'fic_equipment_id' => $model->id], ['class' => 'small-box-footer']) ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Right Side End -->
</div>