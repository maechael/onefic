<?php

use app\models\Region;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

?>

<div class="facility-form">
    <?php $form = ActiveForm::begin([
        'id' => 'form-update',
        'action' => "/part/update?id={$model->id}",
        'options' => [
            //'data-pjax' => true
        ]
    ]); ?>

    <?= Html::activeHiddenInput($model, "isImageChanged", ['value' => 0]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group field-part-imagefile">
        <?= Html::input('file', 'Part[imageFile]', null, [
            'id' => 'partimagefile',
            'class' => 'file',
            'accept' => 'image/*'
        ]) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-block']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<?php
if (isset($model->media))
    $this->registerJsVar('previewUrls', [$model->media->link]);
else
    $this->registerJsVar('previewUrls', []);
$this->registerJs(<<<JS
    isImageChanged = $('#part-isimagechanged');
    // previewUrls = [];
    // $("#partimagefile").fileinput();

    $('#partimagefile').on('fileclear', e => {
        isImageChanged.val('1');
    });

    $('#partimagefile').on('filebatchselected', e => {
        isImageChanged.val('1');
    });

    
JS);
