<?php

use app\assets\LeafletAsset;
use app\models\Region;
use kartik\depdrop\DepDrop;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use mdm\admin\models\Route;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;

/**
 *  @var yii\web\View $this 
 **/
/* @var $model app\models\Fic */
/* @var $form yii\widgets\ActiveForm */

LeafletAsset::register($this);

?>

<div class="fic-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['class' => 'form-control form-control-sm', 'maxlength' => true]) ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'suc')->textInput(['class' => 'form-control form-control-sm', 'maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'contact_person')->textInput(['class' => 'form-control form-control-sm', 'maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'contact_number')->textInput(['class' => 'form-control form-control-sm', 'maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'email')->textInput(['class' => 'form-control form-control-sm', 'maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'region_id')->widget(Select2::class, [
                'data' => ArrayHelper::map($regions, 'id', 'code'),
                'size' => Select2::SMALL,
                'options' => ['placeholder' => 'Select a region...'],
                'pluginOptions' => [
                    //'allowClear' => true
                ]
            ]) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'province_id')->widget(DepDrop::class, [
                'bsVersion' => '4.x',
                'data' => $selectedProvince,
                'type' => DepDrop::TYPE_SELECT2,
                'select2Options' => [
                    'size' => Select2::SMALL,
                    'pluginOptions' => [
                        //'allowClear' => true
                    ]
                ],
                'pluginOptions' => [
                    'depends' => ['fic-region_id'],
                    'placeholder' => 'Select a province...',
                    'url' => Url::to(['/fic/get-province'])
                ],
                'pluginEvents' => [
                    "depdrop:init" => "function() { console.log('depdrop:init'); }",
                    "depdrop:ready" => "function() { console.log('depdrop:ready'); }",
                    "depdrop:change" => "function(event, id, value, count) { console.log(id); console.log(value); console.log(count); }",
                    "depdrop:beforeChange" => "function(event, id, value) { console.log('depdrop:beforeChange'); }",
                    "depdrop:afterChange" => "function(event, id, value) { console.log('depdrop:afterChange'); }",
                    "depdrop:error" => "function(event, id, value) { console.log('depdrop:error'); }",
                ]
            ]) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'municipality_city_id')->widget(DepDrop::class, [
                'data' => $selectedMunicipality,
                'type' => DepDrop::TYPE_SELECT2,
                'select2Options' => [
                    'size' => Select2::SMALL,
                    'pluginOptions' => [
                        //'allowClear' => true
                    ]
                ],
                'pluginOptions' => [
                    'depends' => ['fic-region_id', 'fic-province_id'],
                    'placeholder' => 'Select a municipality...',
                    'url' => Url::to(['/fic/get-municipality'])
                ]
            ]) ?>
        </div>
    </div>

    <!-- 
        <?= $form->field($model, 'facilityIds')->widget(Select2::class, [
            'data' => ArrayHelper::map($facilities, 'id', 'name'),
            'size' => Select2::SMALL,
            'options' => [
                'multiple' => true,
                'placeholder' => 'Select facilities...',
                'autocomplete' => 'off'
            ],
            'pluginOptions' => [
                'allowClear' => true
            ]
        ]) ?> 
    -->

    <?= $form->field($model, 'address')->textInput(['class' => 'form-control form-control-sm', 'maxlength' => true]) ?>

    <?= Html::activeHiddenInput($model, "longitude", ['value' => $model->isNewRecord ? 0 : $model->longitude, 'class' => 'longitude-field']); ?>

    <?= Html::activeHiddenInput($model, "latitude", ['value' => $model->isNewRecord ? 0 : $model->latitude, 'class' => 'latitude-field']); ?>

    <div id="map" style="height: 375px;"></div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-sm btn-block mt-1']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
// $data = file_get_contents('../web/js/ph-geojson/regions/medres/regions.0.01.json');

$this->registerJsVar('long', $model->isNewRecord ? 0 : $model->longitude);
$this->registerJsVar('lat', $model->isNewRecord ? 0 : $model->latitude);
// $this->registerJsVar('geoFeatureCollection', Json::decode($data));
$this->registerJs(<<<JS
    // default: 'https://tile.openstreetmap.org/{z}/{x}/{y}.png'
    var map = L.map('map').setView([14.491168127433735, 121.05203801440267], 5);
    // var geoLayer = L.geoJSON(geoFeatureCollection).addTo(map);
    var marker = L.marker([lat, long]);

    marker.addTo(map);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        minZoom: 3,
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    map.on('click', (e)=>{
        //..e.latlng.lat
        //..e.latlng.lng
        marker.setLatLng(e.latlng);
        marker.addTo(map);

        $('.longitude-field').val(e.latlng.lng);
        $('.latitude-field').val(e.latlng.lat);

        console.log(e.latlng.lng, e.latlng.lat);
        // console.log(geojsonFeature);
    });
JS);
