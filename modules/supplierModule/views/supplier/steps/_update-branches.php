<?php

use app\models\Region;
use kartik\depdrop\DepDrop;
use kartik\file\FileInput;
use kartik\select2\Select2;
use kidzen\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrapper_branch', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
    'widgetBody' => '.branch-items', // required: css class selector
    'widgetItem' => '.branch-item', // required: css class
    'limit' => 20, // the maximum times, an element can be cloned (default 999)
    'min' => 0, // 0 or 1 (default 1)
    'insertButton' => '.add-branch', // css class
    'deleteButton' => '.remove-branch', // css class
    'model' => $branches[0],
    'formId' => $form->id,
    'formFields' => [
        'id',
        'supplier_id',
        // 'contact_person',
        // 'email',
        // 'cellNumber',
        // 'telNumber'
    ],
]);
?>
<div class="card w-100">
    <div class="card-body">
        <button type="button" class="add-branch btn btn-success btn-sm float-right mb-1"><i class="fas fa-plus"></i> Add Branch</button>
        <div class="branch-items">
            <?php foreach ($branches as $i => $branch) : ?>
                <div class="branch-item">
                    <div class="d-flex">
                        <button type="button" class="remove-branch btn btn-danger btn-sm mb-1"><i class="fas fa-minus"></i> Remove Branch</button>
                    </div>
                    <div class="card">
                        <div class="card-header bg-primary">Contact Information</div>
                        <div class="card-body">
                            <?php
                            if (!$branch->isNewRecord) {
                                echo Html::activeHiddenInput($branch, "[{$i}]id");
                                echo Html::activeHiddenInput($branch, "[{$i}]supplier_id");
                            } ?>
                            <div class="d-flex">
                                <div class="flex-fill">
                                    <?= $form->field($branch, "[{$i}]contact_person")->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class="pl-2 flex-fill">
                                    <?= $form->field($branch, "[{$i}]email")->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="flex-fill">
                                    <?= $form->field($branch, "[{$i}]cellNumber")->textInput(['maxlength' => true]) ?>
                                </div>
                                <div class="pl-2 flex-fill">
                                    <?= $form->field($branch, "[{$i}]telNumber")->textInput(['maxlength' => true]) ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-primary">Address Information</div>
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-fill">
                                    <?= $form->field($branch, "[{$i}]region_id")->widget(Select2::class, [
                                        'data' => ArrayHelper::map(Region::getRegions(), 'id', 'code'),
                                        'options' => [
                                            'placeholder' => 'Select a region...',
                                            'class' => 'depdrop-custom',
                                            'data-depdrop-id' => 'region',
                                            'data-item-class' => 'branch-item',
                                        ],
                                    ]) ?>
                                </div>

                                <div class="pl-2 flex-fill">
                                    <?= $form->field($branch, "[{$i}]province_id")->widget(Select2::class, [
                                        'data' => [],
                                        'options' => [
                                            'placeholder' => 'Select a province...',
                                            'class' => 'depdrop-custom',
                                            'data' => [
                                                'depends' => "region",
                                                'url' => Url::to(['/fic/get-province']),
                                                'depdrop-id' => 'province',
                                                'item-class' => 'branch-item',
                                                'value' => $branch->province_id
                                            ], 'disabled' => true,
                                        ],
                                    ]) ?>
                                </div>

                                <div class="pl-2 flex-fill">
                                    <?= $form->field($branch, "[{$i}]municipality_city_id")->widget(Select2::class, [
                                        'data' => [],
                                        'options' => [
                                            'placeholder' => 'Select a municipality...',
                                            'class' => 'depdrop-custom',
                                            'data' => [
                                                'depends' => "region province",
                                                'url' => Url::to(['/fic/get-municipality']),
                                                'depdrop-id' => 'municipality',
                                                'item-class' => 'branch-item',
                                                'value' => $branch->municipality_city_id
                                            ],
                                            'disabled' => true
                                        ],
                                    ]) ?>
                                </div>
                            </div>

                            <?= $form->field($branch, "[{$i}]address")->textarea(['maxlength' => true]) ?>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-primary">Business Files</div>
                        <div class="card-body">
                            <?= $form->field($branch, "[{$i}]businessFiles[]")->widget(FileInput::class, [
                                'name' => 'businessFiles[]',
                                'options' => [
                                    'class' => 'b-business-files',
                                    'multiple' => true,
                                    'accept' => 'image/*, .pdf'
                                ],
                                'pluginOptions' => [
                                    'allowedFileExtensions' => ["pdf", "png", "jpg", "jpeg"],
                                    'maxFileCount' => 10,
                                    'overwriteInitial' => false,
                                    'showUpload' => false,
                                    'showCancel' => false,
                                    'showClose' => false,
                                    'showRemove' => false,
                                    'initialPreviewAsData' => true,
                                    'initialPreview' => $branch->previewConfigs->previews,
                                    'initialPreviewConfig' => $branch->previewConfigs->configs,
                                    // 'deleteUrl' => Url::to('/media/delete-media'),
                                    'deleteUrl' => Url::to('/media/store-for-delete-id')
                                ]
                            ]); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php DynamicFormWidget::end(); ?>