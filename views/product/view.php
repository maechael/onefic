<?php

use kartik\detail\DetailView;
use kartik\file\FileInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\models\ProductEquipment;
use app\models\Equipment;

/** @var yii\web\View $this */
/** @var app\models\Product $model */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            [
                'attribute' => 'description',
                'format' => 'html'
            ],
            [
                'label' => 'Equipment Involved',
                'format' => 'raw',
                'value' => function ($form, $widget) {
                    return array_reduce($widget->model->productEquipments, function ($carry, $item) {
                        if (!isset($item->equipment))
                            return null;
                        return $carry . Html::button($item->equipment->model, ['class' => 'btn btn-secondary btn-sm mr-1 mb-1']);
                    }, '');
                }

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
                'value' => FileInput::widget([
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
                ])

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
            'heading' => "<i class='fas fa-cheese'></i> {$model->name}",

        ],

    ]) ?>


</div>