<?php

use app\models\Supplier;
use kartik\grid\ActionColumn;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SupplierSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Suppliers';
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
            'main_contact_person',
            'main_contact_celnumber',
            'main_contact_email:email',
            'main_contact_telnumber',
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
            'address',
            // 'status',
            // 'created_at',
            // 'updated_at',

            [
                'class' => ActionColumn::class,
                'dropdown' => true,
                'dropdownButton' => ['class' => 'btn btn-outline-secondary btn-sm'],
                'dropdownMenu' => ['class' => 'text-left']
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
            'type' => GridView::TYPE_DARK,
            'heading' => '<i class="fas fa-truck"></i> Supplier'
        ],
        'toolbar' => [
            [
                // 'content' => Html::a('Create New  <i class="fas fa-plus"></i>', ['create'], ['class' => 'btn btn-sm btn-success'])
                'content' => Html::button('Create New <i class="fas fa-plus"></i>', ['data-toggle' => 'modal', 'data-target' => '#modal-create-supplier', 'class' => 'btn btn-sm btn-success'])
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
<?php
//..Create Equipment Modal
echo $this->render('_create_supplier', [
    'supplier' => new Supplier()
]);
