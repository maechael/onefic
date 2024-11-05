<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Equipment */

$this->title = 'Create Equipment';
$this->params['breadcrumbs'][] = ['label' => 'Equipments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="equipment-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <?= $this->render('_form', [
                    'model' => $model,
                    'types' => $types,
                    'categories' => $categories,
                    'processCapability' => $processCapability
                ]) ?>

            </div>
        </div>
    </div>
</div>