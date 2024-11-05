<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\JobOrderRequest */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Job Order Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <p>
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'fic_id',
                    'request_type',
                    'requestor',
                    'requestor_contact',
                    'requestor_profile_id',
                    'request_description:ntext',
                    'request_date',
                    'status',
                    'date_approved',
                    'request_approved_by',
                    'request_noted_by',
                    'request_personnel_in_charge',
                    'date_accomplished',
                    'created_at',
                    'updated_at',
                ],
            ]) ?>
        </div>
        <!--.col-md-12-->
    </div>
    <!--.row-->
</div>