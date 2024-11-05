<?php

use app\models\EquipmentIssue;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EquipmentIssueSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Issues';
$this->params['breadcrumbs'][] = ['label' => 'FIC Equipments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $ficEquipment->equipment->model, 'url' => ['view', 'id' => $ficEquipment->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row mb-2">
    <div class="col-md-12">
        <?= Html::button('Create Equipment Issue', ['data-toggle' => 'modal', 'data-target' => '#modal-create', 'class' => 'btn btn-success btn-sm']) ?>
    </div>
</div>

<?php echo $this->render(
    '_searchIssue',
    [
        'model' => $searchModel,
        'ficEquipmentId' => $ficEquipment->id
    ]
); ?>
<?php Pjax::begin(['id' => 'issues-pjax', 'timeout' => false, 'clientOptions' => ['method' => 'POST']]); ?>
<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'summaryOptions' => ['class' => 'summary mb-2'],
    'itemOptions' => ['class' => 'item'],
    'itemView' => '_list_issue_item',
    'pager' => [
        'class' => 'yii\bootstrap4\LinkPager',
        'options' => ['class' => 'pagination mt-3'],
    ],
    'layout' => '{summary}<div class="card"><ul class="list-group list-group-flush">{items}</ul></div>{pager}',
    // 'options' => [
    //     'tag' => 'ul',
    //     'class' => 'list-group list-group-flush',
    // ],
    // 'itemView' => function ($model, $key, $index, $widget) {
    //     return Html::a(Html::encode($model->title), ['view', 'id' => $model->id]);
    // },
]) ?>
<?php Pjax::end(); ?>
<?php

//..Create Issue Modal
echo $this->render('_create_issue', [
    'issue' => new EquipmentIssue(),
    'fic_equipment_id' => $ficEquipment->id
]);
