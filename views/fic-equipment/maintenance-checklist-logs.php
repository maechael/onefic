<?php

/**
 * @var app\models\FicEquipment $ficEquipment
 * @var app\models\MaintenanceChecklistLogSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

use kartik\date\DatePicker;
use kartik\grid\ActionColumn;
use kartik\grid\GridView;
use yii\helpers\Html;

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'FIC Equipments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => "{$ficEquipment->serial_number}", 'url' => ['view', 'id' => $ficEquipment->id]];
$this->params['breadcrumbs'][] = "Maintenance Checklists";
?>
<div class="fic-equipment-maintenance-checklist-logs">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'accomplished_by_name',
            "accomplished_by_office",
            [
                'attribute' => 'accomplished_by_date',
                'format' => ['datetime'],
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'id' => null
                ],
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => [
                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ],
                ],
            ],

            'endorsed_by_name',
            "endorsed_by_office",
            [
                'attribute' => 'endorsed_by_date',
                'format' => ['datetime'],
                'filterInputOptions' => [
                    'class' => 'form-control',
                    'id' => null
                ],
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => [
                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ],
                ],
            ],
            [
                'class' => ActionColumn::class,
                'template' => '{pdf-export} {view}',
                'buttons' => [
                    'pdf-export' => function ($url, $model, $key) {
                        return Html::a('<span class="fas fa-file-pdf"></span>', ['/maintenance-checklist-log/pdf-export', 'id' => $key], ['target' => '_blank']);
                    },
                ]
            ],
        ],
        'beforeHeader' => [
            [
                'columns' =>
                [
                    ['content' => 'Accomplished by', 'options' => ['colspan' => 3, 'class' => 'text-center bg-info']],
                    ['content' => 'Endorsed by', 'options' => ['colspan' => 3, 'class' => 'text-center bg-info']]
                ]
            ]

        ],
        'toolbar' => [
            [
                'content' => Html::a('<i class="fas fa-redo-alt"></i>', ['', 'id' => $ficEquipment->id], ['data-pjax' => 1, 'class' => 'btn btn-sm btn-default', 'title' => 'Reset Grid']) .
                    '{toggleData}' .
                    '{export}'
            ],
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'pjax' => false,
        'pjaxSettings' => [
            'options' => [
                'id' => 'ficEquipmentGrid'
            ]
        ],
        'floatHeader' => false,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => 'Maintenance Checklist Log Listing',
            'before' => '<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
        ],
        'toggleDataContainer' => ['class' => 'btn-group btn-group-sm ml-1'],
        'exportContainer' => ['class' => 'btn-group-sm ml-1']
    ]) ?>
</div>