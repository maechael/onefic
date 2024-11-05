<?php

use app\models\JobOrderRequest;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use kartik\select2\Select2;
use yii\helpers\Html;

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
            //         return Html::a($display, ['user-profile/toggle-status', 'id' => $model->id], ['data-method' => 'post', 'class' => 'btn btn-outline-secondary btn-sm btn-block status-toggle']);
            //     },
            //     'filterType' => GridView::FILTER_SELECT2,
            //     'filter' => [
            //         JobOrderRequest::STATUS_PENDING => 'pending',
            //         JobOrderRequest::STATUS_APPROVED => 'approved',
            //         JobOrderRequest::STATUS_DECLINED => 'declined'
            //     ],
            //     'filterWidgetOptions' => [
            //         // 'theme' => Select2::THEME_CLASSIC,
            //         'options' => [
            //             'placeholder' => 'status',
            //         ],
            //         'pluginOptions' => ['allowClear' => true],
            //         // 'size' => Select2::SMALL,
            //         'hideSearch' => true,
            //     ],
            //     'format' => 'raw',
            // ],
            //'date_approved',
            //'request_approved_by',
            //'request_noted_by',
            //'request_personnel_in_charge',
            //'date_accomplished',
            //'created_at',
            //'updated_at',

            [
                'class' => 'kartik\grid\ActionColumn',
                'dropdown' => true,
                'dropdownButton' => ['class' => 'btn btn-outline-secondary btn-sm'],
                'dropdownMenu' => ['class' => 'text-left']
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
            [
                'content' => Html::a('New JO Request  <i class="fas fa-plus"></i>', ['create'], ['class' => 'btn btn-sm btn-success'])
                // Html::a('Create Job Order Request', ['create'], ['class' => 'btn btn-success'])
                //..Html::button('Create New <i class="fas fa-plus"></i>', ['class' => 'btn btn-sm btn-success open-equipment-create-modal'])
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