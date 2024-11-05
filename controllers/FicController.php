<?php

namespace app\controllers;

use app\models\Facility;
use app\models\Fic;
use app\models\FicSearch;
use app\models\MunicipalityCity;
use app\models\Province;
use app\models\Region;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * FicController implements the CRUD actions for Fic model.
 */
class FicController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Fic models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FicSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Fic model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Fic model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Fic();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'regions' => Region::getRegions(),
            'selectedProvince' => [],
            'selectedMunicipality' => [],
            'facilities' => Facility::getFacilities()
        ]);
    }

    /**
     * Updates an existing Fic model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        // $model->facilityIds = ArrayHelper::map($model->facilities, 'id', 'id');
        // if (Yii::$app->request->isAjax) {
        //     if ($this->request->isPost) {
        //         if ($model->load($this->request->post()) && $model->save()) {
        //             return $this->asJson(['success' => true]);
        //         }

        //         $result = [];

        //         foreach ($model->getErrors() as $attribute => $errors) {
        //             $result[Html::getInputId($model, $attribute)] = $errors;
        //         }

        //         return $this->asJson(['validation' => $result]);
        //     }

        //     return $this->renderAjax('_update_fic', [
        //         'model' => $model,
        //         'regions' => Region::getRegions(),
        //         'selectedProvince' => [$model->province->id => $model->province->name],
        //         'selectedMunicipality' => [$model->municipality_city_id => $model->municipalityCity->name],
        //         'facilities' => Facility::getFacilities()
        //     ]);
        // }

        return $this->render('update', [
            'model' => $model,
            'regions' => Region::getRegions(),
            'selectedProvince' => [$model->province->id => $model->province->name],
            'selectedMunicipality' => [$model->municipality_city_id => $model->municipalityCity->name],
            'facilities' => Facility::getFacilities()
        ]);
    }

    /**
     * Deletes an existing Fic model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionGetProvince()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
            $provinces = Province::findAll(['region_id' => $id]);
            $selected = null;

            if ($id != null && count($provinces) > 0) {
                $selected = '';
                foreach ($provinces as $i => $province) {
                    $out[] = ['id' => $province['id'], 'name' => $province['name']];

                    // if ($i == 0) {selects-regions
                    //     $selected = $province['id'];
                    // }
                }


                return ['output' => $out, 'selected' => $selected];
            }
        }

        return ['output' => '', 'selected' => ''];
    }

    public function actionGetMunicipality()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
            $municipalities = MunicipalityCity::findAll(['province_id' => $id]);
            //$out = ArrayHelper::map($provinces, 'id', 'name');
            $selected = null;

            if ($id != null && count($municipalities) > 0) {
                $selected = '';
                foreach ($municipalities as $i => $municipality) {
                    $out[] = ['id' => $municipality['id'], 'name' => $municipality['name']];

                    // if ($i == 0) {
                    //     $selected = $municipality['id'];
                    // }
                }
                return ['output' => $out, 'selected' => $selected];
            }
        }

        return ['output' => '', 'selected' => ''];
    }

    /**
     * Finds the Fic model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Fic the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Fic::findOne($id)) !== null) {
            $model->province_id = $model->municipalityCity->province_id;
            $model->region_id = $model->municipalityCity->region_id;
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
