<?php

use kartik\grid\GridView;
use yii\base\View;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use dominus77\sweetalert2\Alert;

$this->title = "Supplier";
$this->params['breadcrumbs'][] = $this->title;

Alert::widget(['useSessionFlash' => true]);
?>
<div class="row">
    <div class="col-12">
        <?= GridView::widget([

            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'attribute' => 'organization_name',
                    'value' => function ($model) {
                        return Html::a(Html::encode($model->organization_name), ['supplier/view', 'id' => $model->id]);
                    },
                    'format' => 'raw',
                    'filterInputOptions' => [
                        'class' => 'form-control form-control-sm',
                        'id' => null
                    ],
                ],
                'form_of_organization',
                'contact_person',
                'cellNumber',
                'email',
                'telNumber',
                // [
                //     'attribute' => 'province',
                //     'value' => 'province.name', 'filterInputOptions' => [
                //         'class' => 'form-control form-control-sm',
                //         'id' => null
                //     ],
                // ],
                // [
                //     'attribute' => 'municipalityCity',
                //     'value' => 'municipalityCity.name', 'filterInputOptions' => [
                //         'class' => 'form-control form-control-sm',
                //         'id' => null
                //     ],
                // ],
                'address',
                'certificate_ref_num',
                // [
                //     'attribute' => 'region',
                //     'value' => 'region.code',
                //     'filterInputOptions' => [
                //         'class' => 'form-control form-control-sm',
                //         'id' => null
                //     ],
                // ],
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            return Html::button(' view', [
                                'value' => Url::toRoute(['supplier/get-supplier', 'id' => $model->id]),
                                'class' => 'btn btn-info button-modal-view',
                                'data-org-name' => $model->organization_name,
                            ]);
                        }
                    ],
                    'template' => '{view}',

                ],
            ],
            'responsive' => true,
            'hover' => true,
            'condensed' => true,
            'pjax' => true,
            'pjaxSettings' => [
                'options' => [
                    'id' => 'ficSupplierApproval'
                ]
            ],
            'floatHeader' => false,
            'panel' => [
                'type' => GridView::TYPE_DARK,
                'heading' => '<i class="fas fa-toolbox"></i> Supplier'
            ],

            'toggleDataContainer' => ['class' => 'btn-group btn-group-sm ml-1'],
            'exportContainer' => ['class' => 'btn-group-sm ml-1']
        ]); ?>

    </div>
</div>
<?php
Modal::begin([
    'id' => 'view-modal',
    'title' => '',
    'size' => 'modal-lg',
    // 'footer' => '<p>test</p>'
]);
echo "<div id='modal-content'></div>";
Modal::end();
$this->registerJs(<<<JS
    $('body').on('click', '.button-modal-view', (e) => {
        $('#view-modal').modal('show');
        $('#view-modal-label').text($(e.target).attr('data-org-name'));
        $.get(e.target.value, (data) => {
            $('#modal-content').html(data);
        });

    });

JS);
