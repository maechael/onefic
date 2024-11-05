<?php

use app\assets\SweetAlertAsset;
use kartik\grid\GridView;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FacilitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '';
$this->params['breadcrumbs'][] = 'Facilities';
?>
<div class="facility-index">

    <?php //echo $this->render('_search', ['model' => $searchModel]);
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'name',
            'description:ntext',
            'created_at:datetime',
            'updated_at:datetime',

            [
                'class' => 'kartik\grid\ActionColumn',
                'dropdown' => true,
                'dropdownButton' => ['class' => 'btn btn-outline-primary btn-sm'],
                'dropdownMenu' => ['class' => 'text-left'],
                // 'updateOptions' => [
                //     'label' => '<i class="fas fa-pencil-alt"></i> Edit',
                // ],
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::button('<i class="fas fa-pencil-alt"></i> Update', ['value' => $url, 'class' => 'dropdown-item button-modal-update']);
                        // return Html::a('<i class="fas fa-pencil-alt"></i> Update', $url, [
                        //     'title' => 'Update',
                        //     'class' => 'dropdown-item button-modal-update',
                        //     //'data-pjax' => '0',
                        //     // 'data-toggle' => 'modal',
                        //     // 'data-target' => '#update-modal',
                        //     'data-id' => $key
                        // ]);
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
                'id' => 'facilityGrid'
            ]
        ],
        'floatHeader' => false,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<i class="fas fa-laptop-house"></i> Facility'
        ],
        'toolbar' => [
            [
                'content' => Html::button('Create Facility', ['data-toggle' => 'modal', 'data-target' => '#modal-create', 'class' => 'btn btn-success btn-sm'])
                //'content' => $this->render('_create', ['facility' => $facility])
                //'content' => Html::button('Create Facility', ['value' => Url::to('facility/create'), 'class' => 'btn btn-success btn-sm button-modal-create'])
            ],
            // '{export}',
            // '{toggleData}'
        ],
        'toggleDataContainer' => ['class' => 'btn-group btn-group-sm ml-1'],
        'exportContainer' => ['class' => 'btn-group-sm ml-1']
    ]); ?>


</div>
<?php
//..Create Facility Modal
echo $this->render('_create', ['facility' => $facility]);

//..Update Facility Modal
Modal::begin([
    'id' => 'modal-update',
    'headerOptions' => ['class' => 'bg-primary'],
    'title' => 'Update Facility',
    'size' => 'modal-lg',
]);

echo "<div id='modal-update-content'></div>";

Modal::end();

$this->registerJs(<<<JS
    $('body').on('click', '.button-modal-update', (e) => {
        $('#modal-update').modal('show');

        $.get(e.target.value, (data) => {
            $('#modal-update-content').html(data);
        });
    });
JS);
