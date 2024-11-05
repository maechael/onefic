<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use app\models\ProcessingCapability;
use yii\bootstrap4\Modal;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProcessingCapabilitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Processing Capabilities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">


    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => SerialColumn::class],

            'name',
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
                'dropdown' => true,
                'dropdownButton' => ['class' => 'btn btn-outline-secondary btn-sm'],
                'dropdownMenu' => ['class' => 'text-left'],
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::button('<i class="fas fa-pencil-alt"></i> Update', ['value' => $url, 'class' => 'dropdown-item button-modal-update']);
                    }
                ]

            ],

        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'pjax' => true,
        'pjaxSettings' => [
            'options' => [
                'id' => 'processingCapabilityGrid'
            ]
        ],

        'floatHeader' => false,
        'panel' => [
            'type' => GridView::TYPE_DARK,
            'heading' => '<i class="fas fa-warehouse"></i> Processing Capabilities'
        ],
        'toolbar' => [
            [
                'content' => Html::button('Create New <i class="fas fa-plus"></i>', ['data-toggle' => 'modal', 'data-target' => '#modal-create-processing-capabilities', 'class' => 'btn btn-sm btn-success'])
            ],
            '{export}',
            '{toggleData}'
        ],
        'exportConfig' => [
            GridView::EXCEL => [],
            GridView::HTML => [],
        ],
        'toggleDataContainer' => ['class' => 'btn-group btn-group-sm ml-1'],
        'exportContainer' => ['class' => 'btn-group-sm ml-1']

    ]); ?>
</div>
<?= $this->render('_create_processing_capabilities', ['model' => new ProcessingCapability()]); ?>
<?php
Modal::begin([
    'id' => 'modal-update-processing-capability',
    'title' => 'Update Processing Capability',
    'size' => 'modal-md',
]);
echo "<div id='modal-update-content'></div>";
Modal::end();

$this->registerJs(<<<JS
    $('body').on('click', '.button-modal-update', (e) => {
        $('#modal-update-processing-capability').modal('show');

        $.get(e.target.value, (data) => {
            $('#modal-update-content').html(data);
        });
    });
JS);
