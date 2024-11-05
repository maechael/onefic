<?php

use app\assets\LeafletAsset;
use kartik\detail\DetailView;
use yii\helpers\Html;
use yii\widgets\DetailView as WidgetsDetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Fic */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Fics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
\yii\web\YiiAsset::register($this);
LeafletAsset::register($this);
?>
<div class="fic-view">

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
            [
                'group' => true,
                'label' => 'CONTACT INFORMATION',
                'rowOptions' => [
                    'class' => 'table-info'
                ]
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'contact_person',
                    ],
                    [
                        'attribute' => 'email',
                    ],
                    [
                        'attribute' => 'contact_number',
                    ]
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
                    [
                        'attribute' => 'region',
                        'value' => $model->region->code,
                        'valueColOptions' => ['style' => 'width:30%']
                    ],
                    [
                        'attribute' => 'province',
                        'value' => $model->province->name,
                        'valueColOptions' => ['style' => 'width:30%']
                    ]
                ]
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'municipalityCity',
                        'value' => $model->municipalityCity->name,
                        'valueColOptions' => ['style' => 'width:30%']
                    ],
                    [
                        'attribute' => 'address',
                        'valueColOptions' => ['style' => 'width:30%']
                    ],

                ]
            ],
            [
                'group' => true,
                'label' => 'MAP LOCATION',
                'rowOptions' => [
                    'class' => 'table-info'
                ]
            ],
            [
                'attribute' => 'address',
                'label' => false,
                'labelColOptions' => ['class' => 'd-none'],
                'format' => 'raw',
                'value' => "<div id='map' style='height: 500px;'></div>"
            ]
        ],
        'mode' => DetailView::MODE_VIEW,
        'enableEditMode' => false,
        'bordered' => true,
        'striped' => false,
        'condensed' => false,
        'responsive' => true,
        'hover' => false,
        'hideIfEmpty' => false,
        'notSetIfEmpty' => true,
        'hAlign' => DetailView::ALIGN_RIGHT,
        'vAlign' => DetailView::ALIGN_MIDDLE,
        'panel' => [
            'type' => DetailView::TYPE_PRIMARY,
            'heading' => "<i class='fas fa-warehouse'></i> {$model->name}"
        ],
    ]) ?>
</div>
<?php
$this->registerJsVar('long', $model->isNewRecord ? 0 : (isset($model->longitude) ? $model->longitude : 0));
$this->registerJsVar('lat', $model->isNewRecord ? 0 : (isset($model->latitude) ? $model->latitude : 0));
$this->registerJs(<<<JS
    var map = L.map('map', {
        dragging: true,
        zoomControl: true,
        scrollWheelZoom: false
    }).setView([lat, long], 12);
    // var geoLayer = L.geoJSON(geoFeatureCollection).addTo(map);
    var marker = L.marker([lat, long]);

    marker.addTo(map);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        minZoom: 3,
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
JS);
