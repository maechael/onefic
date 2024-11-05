<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Part */
?>
<div class="part-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'media_id',
            'isDeleted',
            'version',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>