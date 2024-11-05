<?php

use app\models\Equipment;
use kartik\editors\Summernote;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


/** @var yii\web\View $this */
/** @var app\models\Product $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name')->textInput(['class' => 'form-control form-control-sm', 'maxlength' => true]) ?>
    <?= $form->field($model, 'description')->widget(Summernote::class, [
        'useKrajeePresets' => false,
        'container' => [
            'class' => ''
        ],
        'pluginOptions' => [
            'toolbar' => [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
            ],
        ],


    ]) ?>
    <?= $form->field($model, 'equipmentIds')->widget(Select2::class, [
        'data' => ArrayHelper::map(Equipment::getEquipments(), 'id', 'model'),
        'theme' => Select2::THEME_DEFAULT,

        'showToggleAll' => true,
        'options' => ['multiple' => true],
        'pluginOptions' => [
            'allowClear' => true,
            'closeOnSelect' => false,
            'dropdownAutoWidth' => true,
            'width' => '100%',
            'scrollAfterSelect' => false
        ]

    ]) ?>
    <?= $form->field($model, 'productImages[]')->widget(FileInput::class, [
        'name' => 'productImage[]',
        'options' => [
            'id' => 'sd-product-files',
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
            'initialPreview' => $filePreviews,
            'initialPreviewConfig' => $previewConfigs,
            // 'deleteUrl' => Url::to('/media/delete-media'),
            'deleteUrl' => Url::to('/media/store-for-delete-id')
        ]

    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
