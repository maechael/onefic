<?php

use app\assets\LeafletAsset;
use app\models\Fic;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap4\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FicSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '';
$this->params['breadcrumbs'][] = 'FIC';
?>
<div class="fic-index">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [

                        [
                            'attribute' => 'name',
                            'filterInputOptions' => [
                                'class' => 'form-control form-control-sm',
                                'id' => null
                            ],
                        ],
                        [
                            'attribute' => 'region',
                            'value' => 'region.code',
                            'filterInputOptions' => [
                                'class' => 'form-control form-control-sm',
                                'id' => null
                            ],
                        ],
                        [
                            'attribute' => 'province',
                            'value' => 'province.name', 'filterInputOptions' => [
                                'class' => 'form-control form-control-sm',
                                'id' => null
                            ],
                        ],
                        [
                            'attribute' => 'municipalityCity',
                            'value' => 'municipalityCity.name',
                            'filterInputOptions' => [
                                'class' => 'form-control form-control-sm',
                                'id' => null
                            ],
                        ],
                        [
                            'attribute' => 'suc',
                            'filterInputOptions' => [
                                'class' => 'form-control form-control-sm',
                                'id' => null
                            ],
                        ],
                        [
                            'attribute' => 'address',
                            'filterInputOptions' => [
                                'class' => 'form-control form-control-sm',
                                'id' => null
                            ],
                        ],
                        // 'created_at:datetime',
                        // 'updated_at:datetime',

                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'dropdown' => false,
                            'dropdownButton' => ['class' => 'btn btn-outline-secondary btn-sm'],
                            'dropdownMenu' => ['class' => 'text-left'],
                            // 'template' => '{update} {delete}',
                            // 'buttons' => [
                            //     'update' => function ($url, $model) {
                            //         return Html::button('<i class="fas fa-pencil-alt"></i> Update', ['value' => $url, 'class' => 'dropdown-item button-modal-update']);
                            //     }
                            // ]
                        ],
                    ],

                    'responsive' => true,
                    'hover' => true,
                    'condensed' => true,
                    'pjax' => false,
                    'pjaxSettings' => [
                        'options' => [
                            'id' => 'ficGrid'
                        ]
                    ],
                    'floatHeader' => false,
                    'panel' => [
                        'type' => GridView::TYPE_PRIMARY,
                        'heading' => '<i class="fas fa-warehouse"></i> Food Innovation Center',
                        'before' => '<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
                    ],
                    'toolbar' => [
                        [
                            'content' => Html::a('<i class="fas fa-plus"></i>', 'create', ['class' => 'btn btn-sm btn-default', 'title' => 'Create FIC']) .
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
<?= $this->render('_create_fic', ['model' => new Fic()]); ?>
<?php
Modal::begin([
    'id' => 'modal-update-fic',
    'title' => 'Update fic',
    'size' => 'modal-lg',
]);
echo "<div id='modal-update-content'></div>";
Modal::end();
$this->registerJs(<<<JS
    $('body').on('click', '.button-modal-update', (e) => {
        $('#modal-update-fic').modal('show');

        $.get(e.target.value, (data) => {
            $('#modal-update-content').html(data);
        });
    });
JS);
