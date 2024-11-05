<?php

use app\models\Facility;
use app\models\Region;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

?>

<div class="facility-form">
    <?php $form = ActiveForm::begin([
        'id' => 'form-update',
        'action' => "/fic/update?id={$model->id}",
        'options' => [
            //'data-pjax' => true
        ]
    ]); ?>
    <?= $form->field($model, 'name')->textInput(['class' => 'form-control form-control-sm', 'maxlength' => true]) ?>
    <?= $form->field($model, 'suc')->textInput(['class' => 'form-control form-control-sm', 'maxlength' => true]) ?>
    <?= $form->field($model, 'region_id', ['inputOptions' => ['id' => 'fic-region_id-update']])->widget(Select2::class, [
        'data' => ArrayHelper::map(Region::getRegions(), 'id', 'code'),
        'size' => Select2::SMALL,
        'options' => ['placeholder' => 'Select a region...'],
        'pluginOptions' => [
            //'allowClear' => true
        ],
        'hashVarLoadPosition' => View::POS_READY
    ]) ?>
    <?= $form->field($model, 'province_id', ['inputOptions' => ['id' => 'fic-province_id-update']])->widget(DepDrop::class, [
        'bsVersion' => '4.x',
        'data' => $selectedProvince,
        'type' => DepDrop::TYPE_SELECT2,
        'select2Options' => [
            'size' => Select2::SMALL,
            'pluginOptions' => [
                //'allowClear' => true
            ]
        ],
        'pluginOptions' => [
            'depends' => ['fic-region_id-update'],
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
    <?= $form->field($model, 'municipality_city_id', ['inputOptions' => ['id' => 'fic-municipality_city_id-update']])->widget(DepDrop::class, [
        'data' => $selectedMunicipality,
        'type' => DepDrop::TYPE_SELECT2,
        'select2Options' => [
            'size' => Select2::SMALL,
            'pluginOptions' => [
                //'allowClear' => true
            ]
        ],
        'pluginOptions' => [
            'depends' => ['fic-region_id-update', 'fic-province_id-update'],
            'placeholder' => 'Select a municipality...',
            'url' => Url::to(['/fic/get-municipality'])
        ]
    ]) ?>
    <?= $form->field($model, 'facilityIds', ['inputOptions' => ['id' => 'fic-facilityIds-update']])->widget(Select2::class, [
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
<?php
$this->registerJs(<<<JS
    $('body').on('beforeSubmit', '#form-update', function() {
        let yiiform = $(this);

        $.ajax({
            type: yiiform.attr('method'),
            url: yiiform.attr('action'),
            data: yiiform.serializeArray(),
        }).done(data => {
            if(data.success){
                $('#modal-update-fic').modal('hide');           //..hides update modal
                yiiform.trigger('reset');    //..resets form
                swal({
                    title: 'Sucess',
                    text: 'Facility successfully created!',
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
