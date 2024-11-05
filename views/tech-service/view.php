<?php

use app\assets\DualListBoxAsset;
use app\models\Equipment;
use app\models\TechService;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\TechService */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Tech Services', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
\yii\web\YiiAsset::register($this);
DualListBoxAsset::register($this);
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <p>
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'name',
                    [
                        'attribute' => 'description',
                        'format' => 'html'
                    ],
                    'created_at',
                    'updated_at',
                ],
            ]) ?>
        </div>
    </div>

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Assigned Equipment</h3>
            <div class="card-tools">
                <button id="btn-assign-equipments" type="button" class="btn btn-tool">
                    <i class="fas fa-pencil-alt"></i>
                </button>

                <button id="btn-submit-equipments" class="btn btn-tool d-none">
                    <i class="fas fa-check"></i>
                </button>

                <button id="btn-cancel" class="btn btn-tool d-none">
                    <i class="fas fa-ban"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="display-container">
                <?php Pjax::begin(); ?>
                <div class="row">
                    <?php if (count($model->equipments) < 1) : ?>
                        <p>No equipment assigned</p>
                    <?php endif; ?>
                    <?php foreach ($model->equipments as $equipment) : ?>
                        <div class="col-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-info">
                                    <i class="fas fa-toolbox"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text"><?= $equipment->model ?></span>
                                    <span class="info-box-number"><?= $equipment->equipmentType->name ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php Pjax::end(); ?>
            </div>

            <div class="update-container d-none">
                <?php $form = ActiveForm::begin([
                    'id' => 'form-assignment',
                    'action' => Url::to('assign-equipment'),
                    'method' => 'POST'
                ]); ?>

                <?= Html::activeHiddenInput($model, 'id') ?>

                <?= $form->field($model, 'equipmentIds')->widget(Select2::class, [
                    'value' => $model->equipmentIds,
                    'data' => ArrayHelper::map(Equipment::getEquipments(), 'id', 'model'),
                    'theme' => Select2::THEME_DEFAULT,
                    'showToggleAll' => true,
                    'options' => [
                        'multiple' => true
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'closeOnSelect' => false,
                        'dropdownAutoWidth' => true,
                        'width' => '100%',
                        'scrollAfterSelect' => false
                    ]
                ]) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerJsVar('equipmentIds', $model->equipmentIds);
$this->registerJs(<<<JS
    let btnCancel = $('#btn-cancel');
    let btnUpdate = $('#btn-assign-equipments');
    let btnSubmit = $('#btn-submit-equipments');

    let displayContainer = $('.display-container');
    let updateContainer = $('.update-container');
    // let dualListbox = $('.duallistbox').bootstrapDualListbox({
    //     selectorMinimalHeight: 400,
    //     moveOnSelect: false,
    //     moveOnDoubleClick: false
    // });

    btnUpdate.on('click', (e)=> {
        show(btnCancel);
        show(displayContainer, false);
        show(updateContainer);
        show($(e.currentTarget), false);
        show(btnSubmit);
    });

    btnSubmit.on('click', (e) => {
        //..insert saving code here
        let yiiform = $('#form-assignment');

        $.ajax({
            type: yiiform.attr('method'),
            url: yiiform.attr('action'),
            data: yiiform.serializeArray(),
        }).done(data => {
            if(data.success){
                equipmentIds = [...data.equipmentIds];
                console.log(equipmentIds);
                $.pjax.reload({container: '#p0'});

                show(displayContainer);
                show(btnUpdate);
                show(updateContainer, false);
                show($(e.currentTarget), false);
                show(btnCancel, false);
            }
        }).fail(() => {

        });

        // show(displayContainer);
        // show(btnUpdate);
        // show(updateContainer, false);
        // show($(e.currentTarget), false);
        // show(btnCancel, false);
    });

    btnCancel.on('click', (e) => {
        $('#techservice-equipmentids').val([...equipmentIds]).trigger('change');
        show(displayContainer);
        show(btnUpdate);
        show(updateContainer, false);
        show($(e.currentTarget), false);
        show(btnSubmit, false);
        show(btnCancel, false);

    });

    function show(elem, isVisible = true){
        elem.toggleClass('d-none', !isVisible);
    }
JS);
