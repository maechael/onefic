<?php

use app\assets\FilterMultiSelectAsset;
use app\models\Equipment;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SupplierSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '';
$this->params['breadcrumbs'][] = 'Supplier';

// FilterMultiSelectAsset::register($this);
?>
<div class="container-fluid">

    <?php echo $this->render('_search', ['model' => $searchModel]);
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            [
                'attribute' => 'organization_name',
                'value' => function ($model) {
                    return Html::a(Html::encode($model->organization_name), ['view', 'id' => $model->id]);
                },
                'format' => 'raw'
            ],
            'form_of_organization',
            'contact_person',
            'email:email',
            //'telNumber',
            //'region_id',
            //'province_id',
            //'municipality_city_id',
            //'address',
            //'is_philgeps_registered',
            'certificate_ref_num',
            //'approval_status',
            //'organization_status',
            //'created_at',
            //'updated_at',

            // ['class' => 'hail812\adminlte3\yii\grid\ActionColumn'],
        ],
        'summaryOptions' => ['class' => 'summary mb-2'],
        'pager' => [
            'class' => 'yii\bootstrap4\LinkPager',
        ]
    ]); ?>

</div>
<?php
$this->registerJs($this->render('_script.js'));
