<?php

use app\models\EquipmentCategory;
use app\models\EquipmentType;
use app\models\ProcessingCapability;
use app\models\Region;
use app\modules\ficModule\models\FicEquipment;
use kartik\depdrop\DepDrop;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\MaskedInput;
use yii\widgets\Pjax;

?>
<?php Modal::begin([
    'id' => 'modal-create-supplier',
    'title' => 'Add Equipment',
    'size' => 'modal-lg',
]); ?>

<div class="supplier-form">
    <?php $form = ActiveForm::begin([
        'id' => 'form-create',
        'action' => 'create',
        'options' => [
            // 'enctype' => 'multipart/form-data',
            //'data-pjax' => true
        ],
        'method' => 'POST',
    ]); ?>

    <?= $form->field($supplier, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($supplier, 'main_contact_person')->textInput(['maxlength' => true]) ?>

    <?= $form->field($supplier, 'main_contact_celnumber')->widget(MaskedInput::class, [
        'mask' => '9999-999-9999'
    ]) ?>

    <?= $form->field($supplier, 'main_contact_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($supplier, 'main_contact_telnumber')->widget(MaskedInput::class, [
        'mask' => '99-9999-9999'
    ]) ?>

    <?= $form->field($supplier, 'region_id')->widget(Select2::class, [
        'data' => ArrayHelper::map(Region::getRegions(), 'id', 'code'),
        'size' => Select2::MEDIUM,
        'options' => ['placeholder' => 'Select a region...'],
        'pluginOptions' => [
            //'allowClear' => true
        ]
    ])->label('Region') ?>

    <?= $form->field($supplier, 'province_id')->widget(DepDrop::class, [
        'bsVersion' => '4.x',
        'data' => [],
        'type' => DepDrop::TYPE_SELECT2,
        'select2Options' => [
            'size' => Select2::MEDIUM,
            'pluginOptions' => [
                //'allowClear' => true
            ]
        ],
        'pluginOptions' => [
            'depends' => ['supplier-region_id'],
            'placeholder' => 'Select a province...',
            'url' => Url::to(['/supplier/get-province'])
        ],
        'pluginEvents' => [
            "depdrop:init" => "function() { console.log('depdrop:init'); }",
            "depdrop:ready" => "function() { console.log('depdrop:ready'); }",
            "depdrop:change" => "function(event, id, value, count) { console.log(id); console.log(value); console.log(count); }",
            "depdrop:beforeChange" => "function(event, id, value) { console.log('depdrop:beforeChange'); }",
            "depdrop:afterChange" => "function(event, id, value) { console.log('depdrop:afterChange'); }",
            "depdrop:error" => "function(event, id, value) { console.log('depdrop:error'); }",
        ]
    ])->label('Provice') ?>

    <?= $form->field($supplier, 'municipality_city_id')->widget(DepDrop::class, [
        'data' => [],
        'type' => DepDrop::TYPE_SELECT2,
        'select2Options' => [
            'size' => Select2::MEDIUM,
            'pluginOptions' => [
                //'allowClear' => true
            ]
        ],
        'pluginOptions' => [
            'depends' => ['supplier-region_id', 'supplier-province_id'],
            'placeholder' => 'Select a municipality...',
            'url' => Url::to(['/supplier/get-municipality'])
        ]
    ])->label('Municipality/City') ?>

    <?= $form->field($supplier, 'address')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php Modal::end();

$this->registerJs(<<<JS
    $('#form-create').on('beforeSubmit', function() {
        let yiiform = $(this);

        $.ajax({
            type: yiiform.attr('method'),
            url: yiiform.attr('action'),
            data: yiiform.serializeArray(),
        }).done(data => {
            if(data.success){
                $('#modal-create-supplier').modal('hide');           //..hides create modal
                yiiform.trigger('reset');                               //..resets form
                // swal({
                //     title: 'Sucess',
                //     text: 'Facility successfully created!',
                //     type: "success"
                // });
                $.pjax.reload({container:'#supplierGrid'}); //..reload gridview
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
