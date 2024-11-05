<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SpecKey */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Spec Keys', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="spec-key-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>