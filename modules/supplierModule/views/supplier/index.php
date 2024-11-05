<?php

use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SupplierSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '';
$this->params['breadcrumbs'][] = 'Supplier';
?>
<div class="container-fluid">
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'organization_name',
            'form_of_organization',
            'contact_person',
            'email:email',
            //'telNumber',
            //'region_id',
            //'province_id',
            //'municipality_city_id',
            //'address',
            //'is_philgeps_registered',
            'certificate_ref_num',
            //'approval_status',
            //'organization_status',
            //'created_at',
            //'updated_at',

            ['class' => 'hail812\adminlte3\yii\grid\ActionColumn'],
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
            'heading' => '<i class="fas fa-boxes"></i> Supplier',
            'before' => '<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
        ],
        'toolbar' => [
            [
                // 'content' => Html::button('Create New <i class="fas fa-plus"></i>', ['data-toggle' => 'modal', 'data-target' => '#modal-create-equipment', 'class' => 'btn btn-sm btn-success'])
                'content' => Html::a('<i class="fas fa-plus"></i>', ['create'], ['class' => 'btn btn-sm btn-default', 'title' => 'Create Supplier']) .
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