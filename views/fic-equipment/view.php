<?php

/**
 * @var app\models\FicEquipment $ficEquipment
 * @var app\models\EquipmentIssue[] $equipmentIssues
 * @var app\models\MaintenanceChecklistLog[] $checklistLogs
 * 
 * @var array $issueCountDatasets
 * @var array $repairCountDatasets
 * @var array $componentIssueCountDatasets
 * @var array $partIssueCountDatasets
 */

use app\widgets\Chart;
use kartik\detail\DetailView;
use yii\bootstrap4\Html;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'FIC Equipments', 'url' => ['index']];
$this->params['breadcrumbs'][] = "{$ficEquipment->serial_number}";
?>
<div class="fic-equipment-view">
    <?= DetailView::widget([
        'model' => $ficEquipment,
        'attributes' => [
            [
                'group' => true,
                'label' => 'EQUIPMENT DETAILS',
                'rowOptions' => [
                    'class' => 'table-info'
                ]
            ],
            // [
            //     'attribute' => 'equipment',
            //     'value' => function ($form, $widget) {
            //         return $widget->model->equipment->model;
            //     }
            // ],
            // [
            //     'attribute' => 'fic',
            //     'value' => function ($form, $widget) {
            //         return $widget->model->fic->name;
            //     }
            // ],
            [
                'columns' => [
                    [
                        'attribute' => 'equipment',
                        'valueColOptions' => ['style' => 'width:30%'],
                        'value' => function ($form, $widget) {
                            return $widget->model->equipment->model;
                        }
                    ],
                    [
                        'attribute' => 'fic',
                        'label' => 'FIC',
                        'valueColOptions' => ['style' => 'width:30%'],
                        'value' => function ($form, $widget) {
                            return $widget->model->fic->name;
                        }
                    ]
                ]
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'serial_number',
                        'valueColOptions' => ['style' => 'width:30%'],
                    ], [
                        'attribute' => 'statusDisplay',
                        'label' => 'Status',
                        'valueColOptions' => ['style' => 'width:30%'],
                    ]
                ]
            ],
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
            'heading' => "<i class='fas fa-toolbox'></i> {$ficEquipment->equipment->model} ({$ficEquipment->serial_number})"
        ],
    ]) ?>

    <div class="row">
        <div class="col-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h5 class="m-0">Issues</h5>
                </div>
                <div class="card-body">
                    <?php if (count($equipmentIssues) === 0) : ?>
                        <div class="alert alert-info">
                            <h5><i class="icon fas fa-info"></i>No records yet.</h5>
                            <p>No recorded issue for this equipment yet.</p>
                        </div>
                    <?php endif; ?>
                    <?php if (count($equipmentIssues) > 0) : ?>
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Concern</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($equipmentIssues as $i => $equipmentIssue) : ?>
                                    <tr>
                                        <td><?= $equipmentIssue->title ?></td>
                                        <td><?= $equipmentIssue->statusDisplay ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?= Html::a('...see more', ['issues', 'id' => $ficEquipment->id], ['class' => 'float-right']) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h5 class="m-0">
                        Maintenance Log
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (count($checklistLogs) === 0) : ?>
                        <div class="alert alert-info">
                            <h5><i class="icon fas fa-info"></i>No records yet.</h5>
                            <p>No maintenance has been performed on this equipment.</p>
                        </div>
                    <?php endif; ?>
                    <?php if (count($checklistLogs) > 0) : ?>
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Accomplished By</th>
                                    <th class="text-right">Success Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($checklistLogs as $i => $checklistLog) : ?>
                                    <tr>
                                        <td><?= $checklistLog->accomplished_by_date ?></td>
                                        <td><?= $checklistLog->accomplished_by_name ?></td>
                                        <td class="text-right"><?= $checklistLog->successRate ?>%</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?= Html::a('...see more', ['maintenance-checklist-logs', 'id' => $ficEquipment->id], ['class' => 'float-right']) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Test Area -->
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h5 class="m-0">
                        Graph ng Issue Count per Month for the last 6 months
                    </h5>
                </div>
                <div class="card-body">
                    <?= Chart::widget([
                        'type' => Chart::TYPE_LINE,
                        'options' => [
                            'height' => 100,
                            'width' => 400,
                            // 'class' => 'chart',
                        ],
                        'clientOptions' => [
                            // 'scales' => new JsonException("{
                            //     scales: {
                            //         yAxes: [{
                            //             ticks: {
                            //                 beginAtZero: true
                            //             }
                            //         }]
                            //     }
                            // }")
                        ],
                        'data' => [
                            'labels' => ArrayHelper::getColumn($issueCountDatasets, 'month_name'),
                            'datasets' => [
                                [
                                    'label' => '# of Issue',
                                    'data' => ArrayHelper::getColumn($issueCountDatasets, 'count'),
                                    'backgroundColor' => "rgba(255,99,132,0.2)",
                                    'borderColor' => "rgba(255,99,132,1)",
                                    'pointBackgroundColor' => "rgba(255,99,132,1)",
                                    'pointBorderColor' => "#fff",
                                    'pointHoverBackgroundColor' => "#fff",
                                    'pointHoverBorderColor' => "rgba(255,99,132,1)",
                                ],
                                [
                                    'label' => '# of Repair Activity',
                                    'type' => Chart::TYPE_LINE,
                                    'data' => ArrayHelper::getColumn($repairCountDatasets, 'count'),
                                    'backgroundColor' => "rgba(179,181,198,0.2)",
                                    'borderColor' => "rgba(179,181,198,1)",
                                    'pointBackgroundColor' => "rgba(179,181,198,1)",
                                    'pointBorderColor' => "#fff",
                                    'pointHoverBackgroundColor' => "#fff",
                                    'pointHoverBorderColor' => "rgba(179,181,198,1)",
                                ],
                            ]
                        ]
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h5 class="m-0">Graph ng Mostly lumalabas na component sa issues</h5>
                </div>
                <div class="card-body">
                    <?= Chart::widget([
                        'type' => Chart::TYPE_DOUGHNUT,
                        'options' => [
                            'height' => 200,
                            'width' => 400,
                        ],
                        'clientOptions' => [
                            // 'legend' => [
                            //     'display' => false,
                            //     'position' => 'bottom',
                            //     'labels' => [
                            //         'fontSize' => 14,
                            //         'fontColor' => "#425062",
                            //     ]
                            // ],
                            // 'tooltips' => [
                            //     'enabled' => true,
                            //     'intersect' => true
                            // ],
                            // 'hover' => [
                            //     'mode' => false
                            // ],
                            // 'maintainAspectRatio' => false,
                        ],
                        'data' => [
                            'radius' => '90%',
                            // 'labels' => ['Label 1', 'Label 2', 'Label 3'], // Your labels
                            'labels' => ArrayHelper::getColumn($componentIssueCountDatasets, 'name'),
                            'datasets' => [
                                [
                                    // 'data' => ['90', '17.5', '46.9'], // Your dataset
                                    'data' => ArrayHelper::getColumn($componentIssueCountDatasets, 'count'),
                                    'label' => '',
                                    'backgroundColor' => [
                                        '#ADC3FF',
                                        '#FF9A9A',
                                        'rgba(190, 124, 145, 0.8)'
                                    ],
                                    'borderColor' =>  [
                                        '#fff',
                                        '#fff',
                                        '#fff'
                                    ],
                                    'borderWidth' => 1,
                                    'hoverBorderColor' => ["#999", "#999", "#999"],
                                ]
                            ]
                        ]
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h5 class="m-0">Graph ng Mostly lumalabas na parts sa issues</h5>
                </div>
                <div class="card-body">
                    <?= Chart::widget([
                        'type' => Chart::TYPE_DOUGHNUT,
                        'options' => [
                            'height' => 200,
                            'width' => 400,
                        ],
                        'clientOptions' => [
                            // 'legend' => [
                            //     'display' => false,
                            //     'position' => 'bottom',
                            //     'labels' => [
                            //         'fontSize' => 14,
                            //         'fontColor' => "#425062",
                            //     ]
                            // ],
                            // 'tooltips' => [
                            //     'enabled' => true,
                            //     'intersect' => true
                            // ],
                            // 'hover' => [
                            //     'mode' => false
                            // ],
                            // 'maintainAspectRatio' => false,
                        ],
                        'data' => [
                            'radius' => '90%',
                            'labels' => ArrayHelper::getColumn($partIssueCountDatasets, 'name'),
                            'datasets' => [
                                [
                                    'data' => ArrayHelper::getColumn($partIssueCountDatasets, 'count'),
                                    'label' => '',
                                    'backgroundColor' => [
                                        '#ADC3FF',
                                        '#FF9A9A',
                                        'rgba(190, 124, 145, 0.8)'
                                    ],
                                    'borderColor' =>  [
                                        '#fff',
                                        '#fff',
                                        '#fff'
                                    ],
                                    'borderWidth' => 1,
                                    'hoverBorderColor' => ["#999", "#999", "#999"],
                                ]
                            ]
                        ]
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

</div>