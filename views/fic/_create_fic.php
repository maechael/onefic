<?php

use app\models\Equipment;
use app\models\EquipmentCategory;
use app\models\EquipmentType;
use app\models\Facility;
use app\models\ProcessingCapability;
use app\models\Region;
use app\modules\ficModule\models\FicEquipment;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;


?>
<?php Modal::begin([
    'id' => 'modal-create-fic',
    'title' => 'Add FIC',
    'size' => 'modal-lg',
    // 'toggleButton' => [
    //     'label' => 'Create Facility',
    //     'class' => 'btn btn-success btn-sm'
    // ],
]); ?>

<div class="facility-form">
    <?php $form = ActiveForm::begin([
        'id' => 'form-create',
        'action' => 'create',
        'options' => [],
        'method' => 'POST',
    ]); ?>
    
    <?= $form->field($model, 'name')->textInput(['class' => 'form-control form-control-sm', 'maxlength' => true]) ?>
    <?= $form->field($model, 'suc')->textInput(['class' => 'form-control form-control-sm', 'maxlength' => true]) ?>
    <?= $form->field($model, 'region_id')->widget(Select2::class, [
        'data' => ArrayHelper::map(Region::getRegions(), 'id', 'code'),
        'size' => Select2::SMALL,
        'options' => ['placeholder' => 'Select a region...'],
        'pluginOptions' => [
            //'allowClear' => true
        ]
    ]) ?>
    <?= $form->field($model, 'province_id')->widget(DepDrop::class, [
        'bsVersion' => '4.x',
        'data' => [],
        'type' => DepDrop::TYPE_SELECT2,
        'select2Options' => [
            'size' => Select2::SMALL,
            'pluginOptions' => [
                //'allowClear' => true
            ]
        ],
        'pluginOptions' => [
            'depends' => ['fic-region_id'],
            'placeholder' => 'Select a province...',
            'url' => Url::to(['/fic/get-province'])
        ],
        'pluginEvents' => [
            "depdrop:init" => "function() { console.log('depdrop:init'); }",
            "depdrop:ready" => "function() { console.log('depdrop:ready'); }",
            "depdrop:change" => "function(event, id, value, count) { console.log(id); console.log(value); console.log(count); }",
            "depdrop:beforeChange" => "function(event, id, value) { console.log('depdrop:beforeChange'); }",
            "depdrop:afterChange" => "function(event, id, value) { console.log('depdrop:afterChange'); }",
            "depdrop:error" => "function(event, id, value) { console.log('depdrop:error'); }",
        ]
    ]) ?>
    <?= $form->field($model, 'municipality_city_id')->widget(DepDrop::class, [
        'data' => [],
        'type' => DepDrop::TYPE_SELECT2,
        'select2Options' => [
            'size' => Select2::SMALL,
            'pluginOptions' => [
                //'allowClear' => true
            ]
        ],
        'pluginOptions' => [
            'depends' => ['fic-region_id', 'fic-province_id'],
            'placeholder' => 'Select a municipality...',
            'url' => Url::to(['/fic/get-municipality'])
        ]
    ]) ?>
    <?= $form->field($model, 'facilityIds')->widget(Select2::class, [
        'data' => ArrayHelper::map(Facility::getFacilities(), 'id', 'name'),
        'size' => Select2::SMALL,
        'options' => [
            'multiple' => true,
            'placeholder' => 'Select facilities...',
            'autocomplete' => 'off'
        ],
        'pluginOptions' => [
            'allowClear' => true
        ]
    ]) ?>
    <?= $form->field($model, 'address')->textInput(['class' => 'form-control form-control-sm', 'maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php Modal::end();

$this->registerJs(<<<JS
    $('#form-create').on('beforeSubmit', function() {
        let yiiform = $(this);
        // console.log(yiiform.yiiActiveForm('find', 'equipment-imagefile').value);
        $.ajax({
            type: yiiform.attr('method'),
            url: yiiform.attr('action'),
            data: yiiform.serializeArray(),
            
        }).done(data => {
            if(data.success){
                $('#modal-create-fic').modal('hide');           //..hides create modal
                yiiform.trigger('reset');                               //..resets form
                swal({
                    title: 'Sucess',
                    text: 'Fic successfully created!',
                    type: "success"
                });
                $.pjax.reload({container:'#ficGrid'}); //..reload gridview
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
