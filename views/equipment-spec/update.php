<?php

/* @var $this yii\web\View */
/* @var $model app\models\EquipmentSpec */

// $this->title = 'Update Equipment Spec: ' . $model->id;
// $this->params['breadcrumbs'][] = ['label' => 'Equipment Specs', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Update';
?>

<div class="container-fluid">
    <?= $this->render('_form', [
        'equipmentSpecs' => $equipmentSpecs
    ]) ?>
</div>