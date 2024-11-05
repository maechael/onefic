<?php

use app\models\Part;
use kartik\date\DatePicker;
use kartik\grid\GridView;
use kartik\grid\SerialColumn;
use yii\bootstrap4\Modal;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PartSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '';
$this->params['breadcrumbs'][] = 'Parts';
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => SerialColumn::class],

                    'name',
                    [
                        'attribute' => 'created_at',
                        'value' => 'created_at',
                        'format' => ['datetime'],
                        'filterInputOptions' => [
                            'class' => 'form-control form-control-sm',
                            'id' => null
                        ],
                        'filterType' => GridView::FILTER_DATE,
                        'filterWidgetOptions' => [
                            'type' => DatePicker::TYPE_COMPONENT_APPEND,
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ],
                        ],
                    ],
                    [
                        'attribute' => 'updated_at',
                        'value' => 'updated_at',
                        'format' => ['datetime'],
                        'filterInputOptions' => [
                            'class' => 'form-control form-control-sm',
                            'id' => null
                        ],
                        'filterType' => GridView::FILTER_DATE,
                        'filterWidgetOptions' => [
                            'type' => DatePicker::TYPE_COMPONENT_APPEND,
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ],
                        ],
                    ],

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
                        'id' => 'partGrid'
                    ]
                ],
                'floatHeader' => false,
                'panel' => [
                    'type' => GridView::TYPE_PRIMARY,
                    'heading' => '<i class="fas fa-cog"></i> Equipment Parts',
                    'before' => '<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
                ],
                'toolbar' => [
                    [
                        'content' => Html::button('<i class="fas fa-plus"></i>', ['data-toggle' => 'modal', 'data-target' => '#modal-create-part', 'class' => 'btn btn-sm btn-default', 'title' => 'Create Part']) .
                            Html::a('<i class="fas fa-redo-alt"></i>', ['',], ['data-pjax' => 1, 'class' => 'btn btn-sm btn-default', 'title' => 'Reset Grid']) .
                            '{toggleData}' .
                            '{export}'
                    ],
                ],
                'toggleDataContainer' => ['class' => 'btn-group btn-group-sm ml-1'],
                'exportContainer' => ['class' => 'btn-group-sm ml-1']
            ]); ?>
        </div>
        <!--.col-md-12-->
    </div>
    <!--.row-->
</div>
<?= $this->render('_create_part', ['part' => new Part()]); ?>
<?php
Modal::begin([
    'id' => 'modal-update-part',
    'headerOptions' => ['class' => 'bg-primary'],
    'title' => 'Update Part',
    'size' => 'modal-lg',
]);
echo "<div id='modal-update-content'></div>";
Modal::end();

$this->registerJs(<<<JS
    let isImageChanged = null;
    // let previewUrls = [];

    $('body').on('click', '.button-modal-update', (e) => {
        $('#modal-update-part').modal('show');
        // $("#partimagefile").fileinput('reset');
        $('#modal-update-content').load(e.currentTarget.value, null, function(){

            $("#partimagefile").fileinput('destroy')
            .fileinput({
                'showUpload': false,
                'showCancel': false,
                'initialPreview': typeof previewUrls === 'undefined' ? []: previewUrls,
                'initialPreviewAsData': true,
                'overwriteInitial': true,
                'allowedFileExtensions': ['jpg', 'png'],
                // 'initialCaption': '',
                // 'initialPreviewConfig':[],
                // 'previewFileType':'any'
            });
        });

        // $.get(e.target.value, (data) => {
        //     $('#modal-update-content').html(data);
        // });
    });

    $('body').on('beforeSubmit', '#form-update', function() {
        let yiiform = $(this);
        let formData = new FormData($('#form-update')[0]);
        $.ajax({
            type: yiiform.attr('method'),
            url: yiiform.attr('action'),
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            // data: yiiform.serializeArray(),
        }).done(data => {
            if(data.success){
                $('#modal-update-part').modal('hide');           //..hides update modal
                yiiform.trigger('reset');                   //..resets form
                $.pjax.reload({container:'#partGrid'}); //..reload gridview
            } else if (data.validation) {
                yiiform.yiiActiveForm('updateMessages', data.validation, true);
            } else {
                // incorrect server response
            }
        }).fail(() => {
            // request failed
        });

        return false;
    });
JS);
