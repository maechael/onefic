<?php

use app\models\Region;
use kartik\checkbox\CheckboxX;
use kartik\depdrop\DepDrop;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

?>
<div class="card">
    <div class="card-header bg-primary">Organization Information</div>
    <div class="card-body">
        <div class="d-flex">
            <div class="flex-fill">
                <?= $form->field($supplier, 'organization_name')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="pl-2 flex-fill">
                <?= $form->field($supplier, 'form_of_organization')->widget(Select2::class, [
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
                <?= $form->field($supplier, 'is_philgeps_registered')->widget(CheckboxX::class, [
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
                <?= $form->field($supplier, 'certificate_ref_num')->textInput([
                    'maxlength' => true,
                    'disabled' => true
                ]) ?>
            </div>
        </div>
        <div class="d-flex">
            <div class="flex-fill">
                <?= $form->field($supplier, 'web_address')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-primary">Contact Information</div>
    <div class="card-body">
        <div class="d-flex">
            <div class="flex-fill">
                <?= $form->field($supplier, 'contact_person')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="pl-2 flex-fill">
                <?= $form->field($supplier, 'email')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="d-flex">
            <div class="flex-fill">
                <?= $form->field($supplier, 'cellNumber')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="pl-2 flex-fill">
                <?= $form->field($supplier, 'telNumber')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-primary">Address Information</div>
    <div class="card-body">
        <div class="d-flex">
            <div class="flex-fill">
                <?= $form->field($supplier, 'region_id')->widget(Select2::class, [
                    'data' => ArrayHelper::map(Region::getRegions(), 'id', 'code'),
                    // 'size' => Select2::SMALL,
                    'options' => ['placeholder' => 'Select a region...'],
                    'pluginOptions' => [
                        //'allowClear' => true
                    ]
                ]) ?>
            </div>

            <div class="pl-2 flex-fill">
                <?= $form->field($supplier, 'province_id')->widget(DepDrop::class, [
                    'bsVersion' => '4.x',
                    'data' => [],
                    'type' => DepDrop::TYPE_SELECT2,
                    'select2Options' => [
                        // 'size' => Select2::SMALL,
                        'pluginOptions' => [
                            'placeholder' => 'Select a province...'
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
                <?= $form->field($supplier, 'municipality_city_id')->widget(DepDrop::class, [
                    'data' => [],
                    'type' => DepDrop::TYPE_SELECT2,
                    'select2Options' => [
                        // 'size' => Select2::SMALL,
                        'pluginOptions' => [
                            'placeholder' => 'Select a municipality...'
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

        <?= $form->field($supplier, 'address')->textarea(['maxlength' => true]) ?>
    </div>
</div>

<div class="card">
    <div class="card-header bg-primary">Business Files</div>
    <div class="card-body">
        <?= $form->field($supplier, 'businessFiles[]')->widget(FileInput::class, [
            'name' => 'businessFiles[]',
            'options' => [
                'id' => 'sd-business-files',
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