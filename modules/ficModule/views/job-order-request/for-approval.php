<?php

use app\models\JobOrderRequest;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\ficModule\models\JobOrderRequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Job Order Requests';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => SerialColumn::class],
            // [
            //     'class' => 'kartik\grid\ExpandRowColumn',
            //     'width' => '60px',
            //     'value' => function ($model, $key, $index, $column) {
            //         return GridView::ROW_COLLAPSED;
            //     },
            //     // uncomment below and comment detail if you need to render via ajax
            //     'detailUrl' => Url::to(['job-order-request/expand-approval-details']),
            //     // 'detail' => function ($model, $key, $index, $column) {
            //     //     return Yii::$app->controller->renderPartial('_expand-row-details', ['model' => $model]);
            //     // },
            //     'headerOptions' => ['class' => 'kartik-sheet-style'],
            //     'expandOneOnly' => true,
            //     'enableRowClick' => true
            // ],
            // 'id',
            // 'fic_id',
            'request_type',
            'requestor',
            'requestor_contact',
            //'requestor_profile_id',
            'request_description:ntext',
            'request_date',
            // [
            //     'attribute' => 'status',
            //     'value' => function ($model, $key, $index, $widget) {
            //         switch ($model->status) {
            //             case JobOrderRequest::STATUS_PENDING:
            //                 $display = 'pending';
            //                 break;
            //             case JobOrderRequest::STATUS_APPROVED:
            //                 $display = 'approved';
            //                 break;
            //             case JobOrderRequest::STATUS_DECLINED:
            //                 $display = 'declined';
            //                 break;
            //             default:
            //                 $display = 'pending';
            //         }
            //         return Html::a($display, ['job-order-request/approve-decline', 'id' => $model->id], ['class' => 'btn btn-outline-secondary btn-sm btn-block status-toggle']);
            //     },
            //     'format' => 'raw',
            // ],
            // 'date_approved',
            // 'request_approved_by',
            // 'request_noted_by',
            // 'request_personnel_in_charge',
            // 'date_accomplished',
            // 'created_at',
            // 'updated_at',

            [
                'class' => 'kartik\grid\ActionColumn',
                'buttonOptions' => [
                    'target' => "_blank"
                ],
                'dropdown' => true,
                'dropdownButton' => ['class' => 'btn btn-outline-secondary btn-sm'],
                'dropdownMenu' => ['class' => 'text-left'],
                'template' => '{approve-decline}',
                'buttons' => [
                    'approve-decline' => function ($url, $model) {
                        return Html::a('<i class="fas fa-thumbs-up"></i> Approve| <i class="fas fa-thumbs-down"></i> Decline', $url, ['class' => 'dropdown-item', 'target' => '_blank', 'data-pjax' => 0]);
                    }
                ]
            ],
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'pjax' => true,
        'floatHeader' => false,
        'panel' => [
            'type' => GridView::TYPE_DARK,
            'heading' => '<i class="fas fa-clipboard-list"></i> Pending Requests'
        ],
        'toolbar' => [
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