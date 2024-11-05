<?php

use app\models\Equipment;
use app\models\EquipmentCategory;
use app\models\EquipmentType;
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\bootstrap4\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EquipmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '';
$this->params['breadcrumbs'][] = 'Equipments';
?>
<div class="equipment-index">

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

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
                            'vAlign' => 'middle',
                        ],
                        [
                            'attribute' => 'equipmentCategory',
                            'value' => 'equipmentCategory.name',
                            'filterInputOptions' => [
                                'class' => 'form-control form-control-sm',
                                'id' => null
                            ],
                            'vAlign' => 'middle',
                        ],
                        [
                            'attribute' => 'processingCapability',
                            'value' => 'processingCapability.name',
                            'filterInputOptions' => [
                                'class' => 'form-control form-control-sm',
                                'id' => null
                            ],
                            'vAlign' => 'middle',
                        ],
                        [
                            'attribute' => 'created_at',
                            'value' => 'created_at',
                            'format' => ['datetime'],
                            'filterInputOptions' => [
                                'class' => 'form-control form-control-sm',
                                'id' => null
                            ],
                            'vAlign' => 'middle',
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
                            'vAlign' => 'middle',
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
                            'dropdownButton' => ['class' => 'btn btn-outline-primary btn-sm'],
                            'dropdownMenu' => ['class' => 'text-left'],
                            'template' => '{checklist} {step-update} {view} {delete}',
                            'buttons' => [
                                'step-update' => function ($url, $model, $key) {
                                    return Html::a('<span class="fas fa-pencil-alt"></span>', $url);
                                },
                                'checklist' => function ($url, $model, $key) {
                                    return Html::a('<span class="fas fa-tasks"></span>', $url);
                                },
                            ]
                        ],

                    ],
                    'responsive' => true,
                    'hover' => true,
                    'condensed' => true,
                    'pjax' => true,
                    'pjaxSettings' => [
                        'options' => [
                            'id' => 'equipmentGrid'
                        ]
                    ],
                    'floatHeader' => false,
                    'panel' => [
                        'type' => GridView::TYPE_PRIMARY,
                        'heading' => '<i class="fas fa-toolbox"></i> Equipment listing',
                        'before' => '<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
                    ],
                    'toolbar' => [
                        [
                            // 'content' => Html::button('Create New <i class="fas fa-plus"></i>', ['data-toggle' => 'modal', 'data-target' => '#modal-create-equipment', 'class' => 'btn btn-sm btn-success'])
                            'content' => Html::a('<i class="fas fa-plus"></i>', ['equipment-setup'], ['class' => 'btn btn-sm btn-default', 'title' => 'Create Equipment']) .
                                Html::a('<i class="fas fa-redo-alt"></i>', ['',], ['data-pjax' => 1, 'class' => 'btn btn-sm btn-default', 'title' => 'Reset Grid']) .
                                '{toggleData}' .
                                '{export}'
                        ],
                    ],
                    'exportConfig' => [
                        GridView::EXCEL => [],
                        GridView::HTML => [],
                    ],
                    'toggleDataContainer' => ['class' => 'btn-group btn-group-sm ml-1'],
                    'exportContainer' => ['class' => 'btn-group-sm ml-1']
                ]); ?>

            </div>
        </div>
    </div>

</div>

<?php

//..Create Equipment Modal
echo $this->render('_create_equipment', [
    'equipment' => new Equipment()
]);
