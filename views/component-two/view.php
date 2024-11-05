<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Component */
?>
<div class="component-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'description:html',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>