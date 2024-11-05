<?php

use app\models\Equipment;
use kartik\editors\Summernote;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

?>
<?php Modal::begin([
    'id' => 'modal-create',
    'title' => 'Add Products',
    'size' => 'modal-lg',

]);
?>
<div class="facility-form">
    <?php $form = ActiveForm::begin([
        'id' => 'form-create',
        'action' => '/product/create',
        'options' => [
            'enctype' => 'multipart/form-data',
        ],
        'method' => 'POST',
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['class' => 'form-control form-control-sm', 'maxlength' => true, 'id' => 'name']) ?>
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
        'size' => Select2::SMALL,
        'options' => ['placeholder' => 'Select equipment...', 'multiple' => true],
        'pluginOptions' => [
            //'allowClear' => true
        ],

    ]) ?>
    <?= $form->field($model, 'productImages[]')->widget(FileInput::class, [
        'name' => 'productImages[]',
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

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-block', 'id' => 'save']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php Modal::end();


$this->registerJs(<<<JS

  $('#form-create').on('beforeSubmit', function() {
    console.log('titi');
  });

JS)

?>