<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use app\models\Service;
use yii\bootstrap4\modal;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ServiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '';
$this->params['breadcrumbs'][] = 'Services';
?>
<div class="container-fluid">
</div>


<?php // echo $this->render('_search', ['model' => $searchModel]); 
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => SerialColumn::class],



        [
            'attribute' => 'name',
            'filterInputOptions' => [
                'class' => 'form-control form-control-sm',
                'id' => null
            ],
        ],
        [
            'attribute' => 'description',
            'format' => 'ntext',
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
            'dropdown' => true,
            'dropdownButton' => ['class' => 'btn btn-outline-primary btn-sm'],
            'dropdownMenu' => ['class' => 'text-left'],
            'template' => '{update} {delete}',
            'buttons' => [
                'update' => function ($url, $model) {
                    return Html::button('<i class="fas fa-pencil-alt"></i> Update', ['value' => $url, 'class' => 'dropdown-item button-modal-update']);
                }
            ]

        ],
    ],
    'floatHeader' => false,
    'panel' => [
        'type' => GridView::TYPE_PRIMARY,
        'heading' => '<i class="fas fa-warehouse"></i> Services'
    ],

    'toolbar' => [
        [
            'content' => Html::button('Create New <i class="fas fa-plus"></i>', ['data-toggle' => 'modal', 'data-target' => '#modal-create-service', 'class' => 'btn btn-sm btn-success'])
        ],
        '{export}',
        '{toggleData}'
    ],
    'toggleDataContainer' => ['class' => 'btn-group btn-group-sm ml-1'],
    'exportContainer' => ['class' => 'btn-group-sm ml-1'],
    'responsive' => true,
    'hover' => true,
    'condensed' => true,
    'pjax' => true,
    'pjaxSettings' => [
        'options' => [
            'id' => 'serviceGrid'
        ]
    ],


]); ?>
<?= $this->render('_create_service', ['model' => new Service()]); ?>

<?php
Modal::begin([
    'id' => 'modal-update-service',
    'headerOptions' => ['class' => 'bg-primary'],
    'title' => 'Update service',
    'size' => 'modal-md',
]);
echo "<div id='modal-update-content'></div>";
Modal::end();

$this->registerJs(<<<JS
    $('body').on('click', '.button-modal-update', (e) => {
        $('#modal-update-service').modal('show');

        $.get(e.target.value, (data) => {
            $('#modal-update-content').html(data);
        });
    });
JS);
