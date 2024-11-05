<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Fic */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Fics', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="fic-update">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <?= $this->render('_form', [
                    'model' => $model,
                    'regions' => $regions,
                    'selectedProvince' => $selectedProvince,
                    'selectedMunicipality' => $selectedMunicipality,
                    'facilities' => $facilities
                ]) ?>
            </div>
        </div>
    </div>
</div>