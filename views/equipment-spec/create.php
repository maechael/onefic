<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EquipmentSpec */

$this->title = 'Create Equipment Spec';
$this->params['breadcrumbs'][] = ['label' => 'Equipment Specs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <?= $this->render('_form', [
        'model' => $model
    ]) ?>
</div>