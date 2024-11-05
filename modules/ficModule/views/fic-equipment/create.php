<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\ficModule\models\FicEquipment */

$this->title = 'Create Fic Equipment';
$this->params['breadcrumbs'][] = ['label' => 'Fic Equipments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?= $this->render('_form', [
                        'model' => $model,
                        'equipments' => $equipments
                    ]) ?>
                </div>
            </div>
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>