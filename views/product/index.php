<?php

use app\models\Equipment;
use app\models\Product;
use app\models\ProductEquipment;
use kartik\grid\GridView;;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;


/** @var yii\web\View $this */
/** @var app\models\ProductSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = '';
$this->params['breadcrumbs'][] = 'product';
?>
<div class="container-fluid">

    <h1><?= Html::encode($this->title) ?></h1>



    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'description',
                'format' => 'html'
            ],
            // [
            //     'attribute' => 'model',
            //     'value' => $model->productEquipments->equipment->model,
            //     'filterInputOptions' => [
            //         'class' => 'form-control form-control-sm',
            //         'id' => null
            //     ],
            // ],
            'created_at',
            'updated_at',
            [
                'class' => 'hail812\adminlte3\yii\grid\ActionColumn',

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
            'heading' => '<i class="fas fa-laptop-house"></i> Product',
            'before' => '<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
        ],
        'toolbar' => [
            [
                'content' => Html::button('<i class="fas fa-plus"></i>', ['data-toggle' => 'modal', 'data-target' => '#modal-create', 'class' => 'btn btn-sm btn-default']) .
                    Html::a('<i class="fas fa-redo-alt"></i>', ['',], ['data-pjax' => 1, 'class' => 'btn btn-sm btn-default', 'title' => 'Reset Grid']) .
                    '{toggleData}' .
                    '{export}'

                //'content' => $this->render('_create', ['facility' => $facility])
                //'content' => Html::button('Create Facility', ['value' => Url::to('facility/create'), 'class' => 'btn btn-success btn-sm button-modal-create'])
            ],
            'exportConfig' => [
                GridView::EXCEL => [],
                GridView::HTML => [],
            ],



        ],
        'toggleDataContainer' => ['class' => 'btn-group btn-group-sm ml-1'],
        'exportContainer' => ['class' => 'btn-group-sm ml-1']


    ]); ?>

</div>
<?php
echo $this->render('_create_product', ['model' => new Product()]);

?>

