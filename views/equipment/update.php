<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Equipment */

$this->title = 'Update Equipment: ' . $model->model;
$this->params['breadcrumbs'][] = ['label' => 'Equipments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->model, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="equipment-update">

    <?= $this->render('_form', [
        'model' => $model,
        'types' => $types,
        'categories' => $categories,
        'processCapability' => $processCapability
    ]) ?>

</div>