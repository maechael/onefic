<?php

use app\models\TechService;
use kartik\grid\ActionColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\bootstrap4\Modal;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TechServiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '';
$this->params['breadcrumbs'][] = 'Tech Service';
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">

            <?php // echo $this->render('_search', ['model' => $searchModel]); 
            ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => SerialColumn::class],
                    'name',
                    [
                        'attribute' => 'description',
                        'format' => 'html',
                        'noWrap' => false
                    ],
                    'created_at',
                    'updated_at',

                    [
                        'class' => ActionColumn::class,
                        'buttons' => [
                            'update' => function ($url, $model) {
                                return Html::a('<span class="fas fa-pencil-alt"></span>', $url, ['class' => 'button-modal-update']);
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
                        'id' => 'supplierGrid'
                    ]
                ],
                'floatHeader' => false,
                'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<i class="fas fa-hands-helping"></i> Tech Service',
                    'before' => '<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
                ],
                'toolbar' => [
                    [
                        'content' => Html::button('<i class="fas fa-plus"></i>', ['data-toggle' => 'modal', 'data-target' => '#modal-create-tech-service', 'class' => 'btn btn-sm btn-default', 'title' => 'Create Tech Service']) .
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
        <!--.col-md-12-->
    </div>
    <!--.row-->
</div>
<?= $this->render('_create_tech_service', [
    'model' => new TechService()
]); ?>

<?php
Modal::begin([
    'id' => 'modal-update-tech-service',
    'title' => 'Update Tech Service',
    'size' => 'modal-lg',
    'headerOptions' => [
        'class' => 'bg-primary'
    ],
    'closeButton' => [
        'class' => 'close text-white'
    ]
]);
echo "<div id='modal-update-content'></div>";
Modal::end();

$this->registerJs(<<<JS
    $('body').on('click', '.button-modal-update', (e) => {
        e.preventDefault();
        $('#modal-update-tech-service').modal('show');
        $.get($(e.currentTarget).attr('href'), (data) => {
            $('#modal-update-content').html(data);
        });
    });
JS);
