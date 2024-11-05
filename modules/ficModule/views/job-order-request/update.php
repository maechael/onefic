<?php

/* @var $this yii\web\View */
/* @var $model app\models\JobOrderRequest */

$this->title = 'Update Job Order Request: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Job Order Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="container-fluid">
    <?= $this->render('_form_request', [
        'model' => $model
    ]) ?>
</div>