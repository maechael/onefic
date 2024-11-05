<?php


use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\Designation;
use kartik\date\DatePicker;
use kartik\grid\SerialColumn;
use yii\bootstrap4\Modal;



/* @var $this yii\web\View */
/* @var $searchModel app\models\DesignationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '';
$this->params['breadcrumbs'][] = 'Designations';
?>
<div class="container-fluid">

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= Gridview::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => SerialColumn::class],


            'name',
            'description:ntext',
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
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'pjax' => true,
        'pjaxSettings' => [
            'options' => [
                'id' => 'designationGrid'
            ]
        ],
        'floatHeader' => false,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<i class="fas fa-warehouse"></i> Designation',
            'before' => '<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
        ],
        'toolbar' => [
            [
                'content' => Html::button('<i class="fas fa-plus"></i>', ['data-toggle' => 'modal', 'data-target' => '#modal-create-designation', 'class' => 'btn btn-sm btn-default', 'title' => 'Create Designation']) .
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

<?= $this->render('_create_designation', ['model' => new Designation()]); ?>
<?php
Modal::begin([
    'id' => 'modal-update-designation',
    'headerOptions' => ['class' => 'bg-primary'],
    'title' => 'Update designation',
    'size' => 'modal-md',
]);
echo "<div id='modal-update-content'></div>";
Modal::end();

$this->registerJs(<<<JS
    $('body').on('click', '.button-modal-update', (e) => {
        $('#modal-update-designation').modal('show');

        $.get(e.target.value, (data) => {
            $('#modal-update-content').html(data);
        });
    });
JS);
