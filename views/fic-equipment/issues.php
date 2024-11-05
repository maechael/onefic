<?php

use kartik\grid\ActionColumn;
use kartik\grid\GridView;
use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'FIC Equipments', 'url' => ['index']];
$this->params['breadcrumbs'][] = "{$ficEquipment->equipment->model} Issues";

?>
<div class="equipment-issues">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'title',
                'label' => 'Concern',
            ],
            [
                'attribute' => 'description',
                'format' => 'raw',
            ],
            [
                'attribute' => 'status',
                'width' => '100px',
                'hAlign' => GridView::ALIGN_CENTER,
                'value' => function ($model) {
                    return $model->statusDisplay;
                },
            ],
            [
                'attribute' => 'reported_by',
            ],
            [
                'class' => ActionColumn::class,
                'width' => '150px',
                'template' => '{issue} {repairs}',
                'buttons' => [
                    'issue' => function ($url, $model, $key) {
                        return Html::a('detail', $url, ['class' => 'btn btn-secondary btn-sm']);
                    },
                    'repairs' => function ($url, $model, $key) {
                        return Html::a('repairs', $url, ['class' => 'btn btn-secondary btn-sm']);
                    }
                ]
            ],
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'pjax' => false,
        'pjaxSettings' => [
            'options' => [
                'id' => 'ficEquipmentGrid'
            ]
        ],
        'floatHeader' => false,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => 'Equipment Issue Listing',
            'before' => '<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
        ],
        'toolbar' => [
            [
                'content' => '{export}' . '{toggleData}'
            ],
        ],
        'toggleDataContainer' => ['class' => 'btn-group btn-group-sm ml-1'],
        'exportContainer' => ['class' => 'btn-group-sm ml-1']
    ]) ?>
</div>
<?php Modal::begin([
    "id" => "dynamicModal",
    'size' => 'modal-xl',
    "footer" => "",
]) ?>
<div id="modalContent"></div>
<?php Modal::end(); ?>
<?php
// $this->registerJs(<<<JS
//     $('body').on('click', '.show-modal-btn', function(e){
//         e.preventDefault();
//         let dModal = $('#dynamicModal');
//         if(dModal.data('bs.modal').isShown){
//             console.log('true');
//         } else {
//             dModal.modal('show')
//                 .find('#modalContent')
//                 .load($(this).attr('href'));
//         }
//     });
// JS);
