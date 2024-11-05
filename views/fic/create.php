<?php

use app\assets\LeafletAsset;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Fic */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Fics', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Create FIC';
?>

<div class="fic-create">
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
<?php
