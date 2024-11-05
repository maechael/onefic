<?php

namespace app\controllers;

use app\models\MaintenanceChecklistLog;
use app\models\MaintenanceChecklistLogSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * MaintenanceChecklistLogController implements the CRUD actions for MaintenanceChecklistLog model.
 */
class MaintenanceChecklistLogController extends Controller
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
     * Lists all MaintenanceChecklistLog models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MaintenanceChecklistLogSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MaintenanceChecklistLog model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MaintenanceChecklistLog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new MaintenanceChecklistLog();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MaintenanceChecklistLog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MaintenanceChecklistLog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionPdfExport($id)
    {
        $checklistLog = $this->findModel($id);
        $indexedCriterias = ArrayHelper::index($checklistLog->checklistCriterias, null, 'component_name');
        $fic = $checklistLog->getFic()->with(['region'])->one();
        $ficEquipment = $checklistLog->getFicEquipment()->with(['equipment'])->one();

        $pdf = Yii::$app->pdf;
        $pdf->cssInline = $this->renderPartial('pdf/inline.css');
        $pdf->content = $this->renderPartial('pdf/_checklist', [
            'checklistLog' => $checklistLog,
            'fic' => $fic,
            'ficEquipment' => $ficEquipment,
            'indexedCriterias' => $indexedCriterias,
        ]);

        return $pdf->render();
    }

    /**
     * Finds the MaintenanceChecklistLog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return MaintenanceChecklistLog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MaintenanceChecklistLog::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
