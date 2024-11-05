<?php

use app\assets\FilterMultiSelectAsset;
use app\models\Equipment;
use app\models\Part;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SupplierSearch */
/* @var $form yii\widgets\ActiveForm */

FilterMultiSelectAsset::register($this);
?>

<div class="row mt-2">
    <div class="col-md-12">

        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
        ]); ?>

        <div class="card">
            <div class="card-body bg-light">
                <div class="row">
                    <div class="col-6">
                        <?= $form->field($model, 'equipments')->dropDownList(
                            ArrayHelper::map(Equipment::getEquipments(), 'id', 'model'),
                            [
                                // 'prompt' => 'Equipment filter..',
                                'multiple' => true,
                                'class' => 'filter-multi-select'
                            ]
                        ) ?>
                    </div>
                    <div class="col-6">
                        <?= $form->field($model, 'parts')->dropDownList(
                            ArrayHelper::map(Part::getParts(), 'id', 'name'),
                            [
                                'multiple' => true,
                                'class' => 'filter-multi-select'
                            ]
                        ) ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
                    <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
    <!--.col-md-12-->
</div>