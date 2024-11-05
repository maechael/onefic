<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SpecKey */

$this->title = 'Create Spec Key';
$this->params['breadcrumbs'][] = ['label' => 'Spec Keys', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="spec-key-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
