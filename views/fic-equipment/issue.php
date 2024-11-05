<?php

use kartik\detail\DetailView;
use kartik\file\FileInput;
use yii\bootstrap4\Html;

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'FIC Equipments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => "{$equipmentIssue->equipment->model} Issues", 'url' => ['issues', 'id' => $equipmentIssue->ficEquipment->id]];
$this->params['breadcrumbs'][] = "{$equipmentIssue->title} Issues";
?>
<div class="equipment-issue-view">
    <?= DetailView::widget([
        'model' => $equipmentIssue,
        'attributes' => [
            [
                'group' => true,
                'label' => 'ISSUE DETAILS',
                'rowOptions' => [
                    'class' => 'table-info'
                ]
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'equipment',
                        'value' => $equipmentIssue->equipment->model,
                        'valueColOptions' => ['style' => 'width:30%']
                    ],
                    [
                        'attribute' => 'statusDisplay',
                        'label' => 'Status',
                        'valueColOptions' => ['style' => 'width:30%']
                    ]
                ]
            ],
            [
                'attribute' => 'reported_by',
                // 'valueColOptions' => ['style' => 'width:30%']
            ],
            [
                'attribute' => 'issueRelatedComponents',
                'label' => 'Related Component(s)',
                'format' => 'raw',
                'value' => function ($form, $widget) {
                    $test = $widget->model->issueRelatedComponents;
                    return array_reduce($widget->model->issueRelatedComponents, function ($carry, $item) {
                        if (!isset($item->component))
                            return null;
                        return $carry . Html::button($item->component->name, ['class' => 'btn btn-secondary btn-sm mr-1 mb-1']);
                    }, '');
                }
            ],
            [
                'attribute' => 'issueRelatedParts',
                'label' => 'Related Part(s)',
                'format' => 'raw',
                'value' => function ($form, $widget) {
                    return array_reduce($widget->model->issueRelatedParts, function ($carry, $item) {
                        if (!isset($item->part))
                            return null;
                        return $carry . Html::button($item->part->name, ['class' => 'btn btn-secondary btn-sm mr-1 mb-1']);
                    }, '');
                }
            ],
            [
                'attribute' => 'description',
                'format' => 'html'
            ],
            [
                'group' => true,
                'label' => 'RELATED IMAGE(S)',
                'rowOptions' => [
                    'class' => 'table-info'
                ]
            ],
            [
                'attribute' => 'equipmentIssueImages',
                'label' => 'Image(s)',
                'format' => 'raw',
                'value' => function ($form, $widget) {
                    return FileInput::widget([
                        'name' => 'asdf',
                        'options' => [
                            'multiple' => true,
                            'accept' => 'image/*',
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
                            'dropZoneTitle' => 'No image(s) provided...',
                            'allowedFileExtensions' => ["png", "jpg", "jpeg"],
                            'initialPreview' => $widget->model->issueImagePreviews['previews'],
                            'initialPreviewConfig' => $widget->model->issueImagePreviews['configs'],
                        ]
                    ]);
                }
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
            'heading' => "<i class='fas fa-exclamation-triangle'></i> {$equipmentIssue->equipment->model} ({$equipmentIssue->title})"
        ],
    ]) ?>


</div>