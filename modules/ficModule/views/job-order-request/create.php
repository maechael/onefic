<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\JobOrderRequest */

$this->title = 'Create Job Order Request';
$this->params['breadcrumbs'][] = ['label' => 'Job Order Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <?= $this->render('_form_request', [
        'model' => $model
    ]) ?>
</div>