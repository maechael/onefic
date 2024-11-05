<?php

use kartik\date\DatePicker;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EquipmentSpecSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Equipment Specs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <!-- <div class="row mb-2">
        <div class="col-md-12">
            <?= Html::a('Create Equipment Spec', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div> -->

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'format' => 'html',
                'value' => function ($data) {
                    return isset($data->image) ? Html::img($data->image->link, ['class' => 'rounded', 'width' => '50', 'height' => '50']) : '';
                }
            ],

            [
                'attribute' => 'equipmentType',
                'value' => 'equipmentType.name',
                'filterInputOptions' => [
                    'class' => 'form-control form-control-sm',
                    'id' => null
                ],
                'vAlign' => 'middle',
                'width' => '180px',
            ],
            [
                'attribute' => 'model',
                'filterInputOptions' => [
                    'class' => 'form-control form-control-sm',
                    'id' => null
                ],
            ],
            [
                'attribute' => 'equipmentCategory',
                'value' => 'equipmentCategory.name',
                'filterInputOptions' => [
                    'class' => 'form-control form-control-sm',
                    'id' => null
                ],
            ],
            [
                'attribute' => 'processingCapability',
                'value' => 'processingCapability.name',
                'filterInputOptions' => [
                    'class' => 'form-control form-control-sm',
                    'id' => null
                ],
            ],
            [
                'attribute' => 'created_at',
                'value' => 'created_at',
                'format' => ['datetime'],
                'filterInputOptions' => [
                    'class' => 'form-control form-control-sm',
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
                'attribute' => 'updated_at',
                'value' => 'updated_at',
                'format' => ['datetime'],
                'filterInputOptions' => [
                    'class' => 'form-control form-control-sm',
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
                'class' => 'kartik\grid\ActionColumn',
                'dropdown' => false,
                'dropdownButton' => ['class' => 'btn btn-outline-secondary btn-sm'],
                'dropdownMenu' => ['class' => 'text-left'],
                'template' => '{update}',
            ],
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'pjax' => true,
        'pjaxSettings' => [
            'options' => [
                'id' => 'equipmentSpecGrid'
            ]
        ],
        'floatHeader' => false,
        'panel' => [
            'type' => GridView::TYPE_DARK,
            'heading' => '<i class="fas fa-laptop-house"></i> Equipment Specs'
        ],
        'toolbar' => [
            [
                // 'content' => Html::button('Create Facility', ['data-toggle' => 'modal', 'data-target' => '#modal-create', 'class' => 'btn btn-success btn-sm'])
            ],
            // '{export}',
            // '{toggleData}'
        ],
        'toggleDataContainer' => ['class' => 'btn-group btn-group-sm ml-1'],
        'exportContainer' => ['class' => 'btn-group-sm ml-1']
    ]); ?>

</div>