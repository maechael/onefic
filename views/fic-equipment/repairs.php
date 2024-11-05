<?php

use yii\helpers\ArrayHelper;

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'FIC Equipments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => "{$equipmentIssue->equipment->model} Issues", 'url' => ['issues', 'id' => $equipmentIssue->ficEquipment->id]];
$this->params['breadcrumbs'][] = "{$equipmentIssue->title} Repairs";

$groupedRepairs = ArrayHelper::index($equipmentIssue->equipmentIssueRepairs, null, function ($element) {
    return Yii::$app->formatter->asDate($element['created_at']);
});
?>
<?php if (count($groupedRepairs) == 0) : ?>
    <div class="alert alert-info">
        No repair activity have been performed.
    </div>
<?php endif; ?>
<?php if (count($groupedRepairs) > 0) : ?>
    <div class="timeline">
        <?php foreach ($groupedRepairs as $date => $repairs) : ?>
            <div class="time-label">
                <span class="bg-secondary"><?= $date ?></span>
            </div>
            <?php foreach ($repairs as $repair) : ?>
                <div>
                    <i class="fas fa-wrench bg-purple"></i>
                    <div class="timeline-item">
                        <span class="time">
                            <i class="fas fa-clock"></i> <?= Yii::$app->formatter->asTime($repair->created_at) ?>
                        </span>
                        <h3 class="timeline-header">
                            <?= $repair->performed_by ?>
                        </h3>
                        <div class="timeline-body">
                            <div class="row">
                                <div class="col-6">
                                    <label>Repair Activity:</label>
                                </div>
                                <?php if (!$repair->remarks == null) : ?>
                                    <div class="col-6">
                                        <label>Remarks:</label>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <?= $repair->repair_activity ?>
                                </div>
                                <?php if (!$repair->remarks == null) : ?>
                                    <div class="col-6">
                                        <?= $repair->remarks ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
        <div>
            <i class="fas fa-clock bg-gray"></i>
        </div>
    </div>
<?php endif; ?>