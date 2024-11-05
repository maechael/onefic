<?php

/** @var yii\web\View $this */

use kartik\grid\ActionColumn;
use kartik\grid\GridView;
use yii\bootstrap4\Html;

$this->title = '';
$this->params['breadcrumbs'][] = 'FIC Equipments';
?>
<div class="fic-equipment-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'attribute' => 'fic',
                'label' => 'FIC',
                'value' => function ($model, $key, $index, $widget) {
                    return $model->fic->name;
                },
                'group' => true,
                // 'groupedRow' => true,
                // 'groupOddCssClass' => 'kv-grouped-row',
                // 'groupEvenCssClass' => 'kv-grouped-row'
            ],
            [
                'attribute' => 'equipment',
                'value' => function ($model, $key, $index, $widget) {
                    return $model->equipment->model;
                }
            ],
            [
                'attribute' => 'serial_number',
            ],
            [
                'attribute' => 'status',
                'value' => function ($model, $key, $index, $widget) {
                    return $model->statusDisplay;
                },
            ],
            [
                'attribute' => 'issueCount',
                'label' => 'Issues',
                'mergeHeader' => true,
                // 'noWrap' => true,
                'hAlign' => GridView::ALIGN_CENTER,
            ],
            [
                'class' => ActionColumn::class,
                'template' => '{view} {issues}',
                'buttons' => [
                    'issues' => function ($url, $model, $key) {
                        return Html::a("<span class='fas fa-exclamation-triangle'></span>", $url, ['title' => 'Issues']);
                    },
                ]
            ],
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => false,
        'pjax' => false,
        'pjaxSettings' => [
            'options' => [
                'id' => 'ficEquipmentGrid'
            ]
        ],
        'floatHeader' => false,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => 'FIC Equipment Listing',
            'before' => '<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
        ],
        'toolbar' => [
            [
                'content' => '{export}' . '{toggleData}'
            ],
            // '{export}',
            // '{toggleData}'
        ],
        'toggleDataContainer' => ['class' => 'btn-group btn-group-sm ml-1'],
        'exportContainer' => ['class' => 'btn-group-sm ml-1']
    ]) ?>
</div>