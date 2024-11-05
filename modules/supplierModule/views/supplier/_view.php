<?php

use kartik\detail\DetailView;
use kartik\form\ActiveForm;
use PharIo\Manifest\Url;
use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;

// var_dump($model->id);
// die;
?>
<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'organization_name',
        'form_of_organization',
        'contact_person',
        'cellNumber',
        'email:email',
        'telNumber',
        [
            'label' => 'Region',
            'value' => "{$model->region->code}({$model->region->name})",
        ],
        [
            'label' => 'Province',
            'value' => $model->province->name,
        ],
        [
            'label' => 'Municipality City',
            'value' => $model->municipalityCity->name,
        ],
        'address',
        'certificate_ref_num',

    ],
]) ?>
<div class="modal-footer">
    <div class="row">
        <div class="ml-7">
            <?= Html::a('Approve', ['supplier/approve-status', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
            <?= Html::a('Reject', ['supplier/reject-status', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">close</button>
        </div>
    </div>
</div>