<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $facility app\models\Facility */

$this->title = 'Update Facility: ' . $facility->name;
$this->params['breadcrumbs'][] = ['label' => 'Facilities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $facility->name, 'url' => ['view', 'id' => $facility->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="facility-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'facility' => $facility,
    ]) ?>

</div>