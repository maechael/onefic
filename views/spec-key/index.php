<?php

use app\models\SpecKey;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use kartik\grid\SerialColumn;
use yii\bootstrap4\Modal;
use dominus77\sweetalert2\Alert;

// use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SpecKeySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '';
$this->params['breadcrumbs'][] = 'Spec Keys';

?>
<div class="spec-key-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- <p> -->
    <!-- <?= Html::a('Create Spec Key', ['create'], ['class' => 'btn btn-success']) ?> -->
    <!-- </p> -->

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <div class="container-fluid">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => SerialColumn::class],
                'name',
                'created_at',
                'updated_at',
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'dropdown' => true,
                    'dropdownButton' => ['class' => 'btn btn-outline-primary btn-sm'],
                    'dropdownMenu' => ['class' => 'text-left'],
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url, $model) {
                            return Html::button('<i class="fas fa-pencil-alt"></i> Update', ['value' => $url, 'class' => 'dropdown-item button-modal-update']);
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
                    'id' => 'specGrid'
                ]
            ],
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<i class="fas fa-warehouse"></i> Specification Key',
                'before' => '<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
            ],
            'toolbar' => [
                [
                    'content' => Html::button('<i class="fas fa-plus"></i>',  ['data-toggle' => 'modal', 'data-target' => '#modal-create-spec', 'class' => 'btn btn-sm btn-default', 'title' => 'Create Specification']) .
                        Html::a('<i class="fas fa-redo-alt"></i>', ['',], ['data-pjax' => 1, 'class' => 'btn btn-sm btn-default', 'title' => 'Reset Grid']) .
                        '{toggleData}' .
                        '{export}'
                ],
            ],
            'toggleDataContainer' => ['class' => 'btn-group btn-group-sm ml-1'],
            'exportContainer' => ['class' => 'btn-group-sm ml-1']
        ]); ?>


    </div>
    <?= $this->render('_create_spec', ['model' => new SpecKey()]); ?>
</div>
<?php
Modal::begin([
    'id' => 'modal-update-spec',
    'headerOptions' => ['class' => 'bg-primary'],
    'title' => 'Update specification',
    'size' => 'modal-md',
]);
echo "<div id='modal-update-content'></div>";
Modal::end();

$this->registerJs(<<<JS
    $('body').on('click', '.button-modal-update', (e) => {
        $('#modal-update-spec').modal('show');

        $.get(e.target.value, (data) => {
            $('#modal-update-content').html(data);
        });
        
    });
    $('#modal-update-spec').on('hidden.bs.modal', function () {
        $('#modal-update-content').empty();
      });

JS);
