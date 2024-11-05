<?php

namespace app\controllers;

use app\models\Facility;
use app\models\FacilitySearch;
use app\models\FicFacility;
use app\models\FicForm;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * FacilityController implements the CRUD actions for Facility model.
 */
class FacilityController extends Controller
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
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Facility models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FacilitySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $facility = new Facility();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'facility' => $facility,
        ]);
    }

    /**
     * Displays a single Facility model.
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
     * Creates a new Facility model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $facility = new Facility();
        if (Yii::$app->request->isAjax) {
            if ($facility->load($this->request->post()) && $facility->save()) {

                //$facility->image = UploadedFile::getInstance($facility, 'image');
                return $this->asJson(['success' => true]);
            }

            $result = [];

            foreach ($facility->getErrors() as $attribute => $errors) {
                $result[Html::getInputId($facility, $attribute)] = $errors;
            }

            return $this->asJson(['validation' => $result]);
        }
        return null;
    }

    /**
     * Updates an existing Facility model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $facility = $this->findModel($id);
        //..scenario of request coming from ajax(update from the modal)
        if (Yii::$app->request->isAjax) {
            if ($this->request->isPost) {
                if ($facility->load($this->request->post()) && $facility->save()) {
                    // return $this->redirect(['view', 'id' => $facility->id]);
                    return $this->asJson(['success' => true]);
                }

                $result = [];

                foreach ($facility->getErrors() as $attribute => $errors) {
                    $result[Html::getInputId($facility, $attribute)] = $errors;
                }

                return $this->asJson(['validation' => $result]);
            }

            return $this->renderAjax('_update', [
                'facility' => $facility,
            ]);
        }
        //..scenario of request coming from the view page
        if ($this->request->isPost && $facility->load($this->request->post()) && $facility->save()) {
            return $this->redirect(['view', 'id' => $facility->id]);
        }

        //..final render catch. From normal get request
        return $this->render('update', [
            'facility' => $facility
        ]);
    }

    /**
     * Deletes an existing Facility model.
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

    /**
     * Finds the Facility model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Facility the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Facility::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
