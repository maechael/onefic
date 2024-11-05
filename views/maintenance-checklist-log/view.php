<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\MaintenanceChecklistLog $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Maintenance Checklist Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="maintenance-checklist-log-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'global_id',
            'fic_equipment_id',
            'accomplished_by_name',
            'accomplished_by_designation',
            'accomplished_by_office',
            'accomplished_by_date',
            'endorsed_by_name',
            'endorsed_by_designation',
            'endorsed_by_office',
            'endorsed_by_date',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
