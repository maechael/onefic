<?php

/* @var $this yii\web\View */
/* @var $model app\modules\ficModule\models\FicEquipment */

$this->title = 'Update Fic Equipment: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Fic Equipments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
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