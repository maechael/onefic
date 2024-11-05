<?php

$this->title = $issue->title;
$this->params['breadcrumbs'][] = ['label' => 'FIC Equipments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $issue->ficEquipment->equipment->model, 'url' => ['view', 'id' => $issue->ficEquipment->id]];
$this->params['breadcrumbs'][] = ['label' => 'Issues', 'url' => ['issues', 'fic_equipment_id' => $issue->ficEquipment->id]];
$this->params['breadcrumbs'][] = $this->title;

?>
<p><?= $issue->description ?></p>