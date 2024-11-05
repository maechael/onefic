<?php

use yii\widgets\ListView;
use yii\widgets\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Maintenance List";
$this->params['breadcrumbs'][] = ['label' => 'Fic Equipments', 'url' => '../fic-equipment/index'];
$this->params['breadcrumbs'][] = ['label' => "{$ficEquipment->equipment->model}", 'url' => Url::to(['fic-equipment/view', 'id' => $ficEquipment->id])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row mb-2">
    <div class="col-md-12">
        <?= Html::a('Maintenance', ['maintain', 'id' => $ficEquipment->id], ['class' => 'btn btn-success']) ?>
    </div>
</div>
<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'summaryOptions' => ['class' => 'summary mb-2'],
    'itemOptions' => ['class' => 'item'],
    'itemView' => '_list_maintenance_item',
    'pager' => [
        'class' => LinkPager::class
    ],
    'layout' => '{items}{pager}',
]) ?>