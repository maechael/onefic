<?php

use app\models\Region;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\checkbox\CheckboxX;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Supplier */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="supplier-form">

    <?php $form = ActiveForm::begin([
        'action' => 'create',
        'options' => [
            'enctype' => 'multipart/form-data',
            //'data-pjax' => true
        ],
        'method' => 'POST',
    ]); ?>

    <div class="card">
        <div class="card-header bg-secondary">Organization Information</div>
        <div class="card-body">
            <div class="d-flex">
                <div class="flex-fill">
                    <?= $form->field($model, 'organization_name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="pl-2 flex-fill">
                    <?= $form->field($model, 'form_of_organization')->widget(Select2::class, [
                        'data' => [
                            'Single Proprietorship' => 'Single Proprietorship',
                            'Partnership' => 'Partnership',
                            'Corporation' => 'Corporation',
                            // 'Limited Liability Company' => 'Limited Liability Company'
                        ],
                        'options' => ['placeholder' => 'Select a form of organization ...'],
                    ]) ?>
                </div>
            </div>
            <div class="d-flex">
                <div class="flex-fill">
                    <?= $form->field($model, 'is_philgeps_registered')->widget(CheckboxX::class, [
                        'autoLabel' => true,
                        'labelSettings' => [
                            'label' => 'PhilGEPS Registered',
                            'position' => CheckboxX::LABEL_RIGHT
                        ],
                        'pluginOptions' => [
                            'threeState' => false,
                            'size' => 'sm'
                        ],
                        'pluginEvents' => [
                            // "change" => "function() { console.log('change'); }",
                            // "reset" => "function() { console.log('reset'); }",
                            "change" => <<<JS
                                function(e){
                                    if(e.target.value == 1){
                                        $('#supplier-certificate_ref_num').prop('disabled', false);
                                    } else {
                                        $('#supplier-certificate_ref_num').val('');
                                        $('#supplier-certificate_ref_num').prop('disabled', true);
                                    }
                                }
                            JS,
                        ]
                    ])->label(false) ?>
                </div>
                <div class="flex-fill">
                    <?= $form->field($model, 'certificate_ref_num')->textInput([
                        'maxlength' => true,
                        'disabled' => true
                    ]) ?>
                </div>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-header bg-secondary">Contact Information</div>
        <div class="card-body">
            <div class="d-flex">
                <div class="flex-fill">
                    <?= $form->field($model, 'contact_person')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="pl-2 flex-fill">
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="d-flex">
                <div class="flex-fill">
                    <?= $form->field($model, 'cellNumber')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="pl-2 flex-fill">
                    <?= $form->field($model, 'telNumber')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-secondary">Address Information</div>
        <div class="card-body">
            <div class="d-flex">
                <div class="flex-fill">
                    <?= $form->field($model, 'region_id')->widget(Select2::class, [
                        'data' => ArrayHelper::map(Region::getRegions(), 'id', 'code'),
                        // 'size' => Select2::SMALL,
                        'options' => ['placeholder' => 'Select a region...'],
                        'pluginOptions' => [
                            //'allowClear' => true
                        ]
                    ]) ?>
                </div>

                <div class="pl-2 flex-fill">
                    <?= $form->field($model, 'province_id')->widget(DepDrop::class, [
                        'bsVersion' => '4.x',
                        'data' => [],
                        'type' => DepDrop::TYPE_SELECT2,
                        'select2Options' => [
                            // 'size' => Select2::SMALL,
                            'pluginOptions' => [
                                //'allowClear' => true
                            ]
                        ],
                        'pluginOptions' => [
                            'depends' => ['supplier-region_id'],
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
                </div>

                <div class="pl-2 flex-fill">
                    <?= $form->field($model, 'municipality_city_id')->widget(DepDrop::class, [
                        'data' => [],
                        'type' => DepDrop::TYPE_SELECT2,
                        'select2Options' => [
                            // 'size' => Select2::SMALL,
                            'pluginOptions' => [
                                //'allowClear' => true
                            ]
                        ],
                        'pluginOptions' => [
                            'depends' => ['supplier-region_id', 'supplier-province_id'],
                            'placeholder' => 'Select a municipality...',
                            'url' => Url::to(['/fic/get-municipality'])
                        ]
                    ]) ?>
                </div>
            </div>

            <?= $form->field($model, 'address')->textarea(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-secondary">Business Files</div>
        <div class="card-body">
            <?= $form->field($model, 'businessFiles[]')->widget(FileInput::class, [
                'name' => 'businessFiles[]',
                'options' => [
                    'multiple' => true,
                    'accept' => 'image/*, application/pdf'
                ],
                'pluginOptions' => [
                    'allowedFileExtensions' => ['pdf', 'png', 'jpg', 'jpeg'],
                    'maxFileCount' => 10,
                    'showUpload' => false,
                    'showCancel' => false
                ]
            ]); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>