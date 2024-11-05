<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Component */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Components', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="component-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>