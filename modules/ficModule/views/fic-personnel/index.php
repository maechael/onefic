<?php

use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\ficModule\models\UserProfileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$fic = Yii::$app->user->identity->userProfile->fic;
$this->title = "{$fic->name} Personnels";
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container-fluid">


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => SerialColumn::class],

            'firstname',
            'lastname',
            'middlename',
            [
                'attribute' => 'designation',
                'value' => 'designation.description',
            ],
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
        'pjaxSettings' => [
            'options' => [
                'id' => 'ficPersonnelGrid'
            ]
        ],
        'floatHeader' => false,
        'panel' => [
            'type' => GridView::TYPE_DARK,
            'heading' => '<i class="fas fa-users"></i> Personnels'
        ],
        'toolbar' => [
            // [
            //     'content' => Html::button('Add Equipment', ['data-toggle' => 'modal', 'data-target' => '#modal-create-fic-equipment', 'class' => 'btn btn-success btn-sm'])
            // ],
            '{export}',
            '{toggleData}'
        ],
        'toggleDataContainer' => ['class' => 'btn-group btn-group-sm ml-1'],
        'exportContainer' => ['class' => 'btn-group-sm ml-1']
    ]); ?>

</div>