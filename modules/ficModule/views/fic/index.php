<?php
/* @var $this yii\web\View */

$this->title = '';
$this->params['breadcrumbs'][] = $fic->name;
?>
<div class="row">
    <div class="col-md-3">

        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <!-- <div class="text-center">
                    <img src="#" alt="FIC profile picture" class="profile-user-img img-fluid img-circle">
                </div> -->
                <h3 class="profile-username text-center"><?= $fic->name ?></h3>
                <p class="text-muted text-center"><?= "{$fic->region->code} ({$fic->region->name})" ?></p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Products</b> <a class="float-right">3</a>
                    </li>
                    <li class="list-group-item">
                        <b>Equipments</b> <a class="float-right">10</a>
                    </li>
                    <li class="list-group-item">
                        <b>Research & Developments</b> <a class="float-right">13,287</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">About Us</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <strong><i class="fas fa-school mr-1"></i> SUC</strong>

                <p class="text-muted">
                    <?= $fic->suc ?>
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                <p class="text-muted"><?= $fic->address ?></p>

                <hr>

                <?php if (count($fic->facilities) > 0) : ?>
                    <strong><i class="fas fa-laptop-house mr-1"></i> Facilities</strong>

                    <p class="text-muted">
                        <?php foreach ($fic->facilities as $facility) : ?>
                            <span class="badge badge-info"><?= $facility->name ?></span>
                        <?php endforeach; ?>
                    </p>

                    <hr>
                <?php endif; ?>
                <?php if (count($fic->services) > 0) : ?>
                    <strong><i class="far fa-file-alt mr-1"></i> Services</strong>

                    <p class="text-muted">
                        <?php foreach ($fic->services as $service) : ?>
                            <span class="badge badge-info"><?= $service->name ?></span>
                        <?php endforeach; ?>
                    </p>
                <?php endif; ?>

            </div>
            <!-- /.card-body -->
        </div>
    </div>

    <div class="col-md-9">
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#mission" class="nav-link" data-toggle="tab">Mission</a></li>
                    <li class="nav-item"><a class="nav-link" href="#vision" class="nav-link" data-toggle="tab">Vision</a></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">

                    <div class="tab-pane active" id='mission'>
                        vision
                    </div>

                    <div class="tab-pane" id='vision'>
                        mission
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>