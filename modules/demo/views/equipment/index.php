<?php
/* @var $this yii\web\View */

use yii\web\View;
use app\models\EquipmentCategory;
use app\models\EquipmentType;
use app\models\FicEquipment;
use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$this->title = 'Equipments';
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- <div class="equipment-index">
    <table id="equipment" class="table table-striped table-bordered table-hover">
        <thead>
            <th>Model</th>
            <th>Serial No.</th>
            <th>Type</th>
            <th>Category</th>
            <th>Status</th>
            <th>Action</th>
        </thead>
        <tbody>
            <tr>
                <td>Can Seamer X001</td>
                <td>XNCS000001</td>
                <td>Can Seamer</td>
                <td>HITS Equipment</td>
                <td>serviceable</td>
                <td></td>
            </tr>
            <tr>
                <td>Vacuum Fryer X001</td>
                <td>XNVF000001</td>
                <td>Vacuum Fryer</td>
                <td>HITS Equipment</td>
                <td>serviceable</td>
                <td></td>
            </tr>
            <tr>
                <td>Spray Dryer X001</td>
                <td>XNSD000001</td>
                <td>Spray Dryer</td>
                <td>HITS Equipment</td>
                <td>un-serviceable</td>
                <td></td>
            </tr>
            <tr>
                <td>Cabinet Dryer X001</td>
                <td>XNCD000001</td>
                <td>Cabinet Dryer</td>
                <td>HITS Equipment</td>
                <td>serviceable</td>
                <td></td>
            </tr>
            <tr>
                <td>Band Sealer X001</td>
                <td>XNVPM000001</td>
                <td>Vacuum Packaging Machine</td>
                <td>Packaging Equipment</td>
                <td>serviceable</td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div> -->
<div class="equipment-view">

</div>
<div class="row">
    <div class="col-md-3">
        <!-- Profile Pic Card -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">



                <h3 class="profile-username text-center"><?= 'E' ?></h3>
                <p class="text-muted text-center">*insert something here</p>

                <hr>
                <strong><i class="fas fa-sitemap mr-1"></i> Equipment Category</strong>
                <p class="text-muted">
                    <?= 'Equipment category' ?>
                </p>

                <hr>

                <strong><i class="fas fa-industry mr-1"></i> Equipment Type</strong>
                <p class="text-muted"><?= 'equipment type' ?></p>

                <hr>

                <div class="d-flex">


                </div>

            </div>
        </div>
        <!-- Profile Pic Card End -->

    </div>
</div>