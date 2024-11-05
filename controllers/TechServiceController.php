<?php

namespace app\controllers;

use app\models\EquipmentTechService;
use Yii;
use app\models\TechService;
use app\models\TechServiceSearch;
use Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * TechServiceController implements the CRUD actions for TechService model.
 */
class TechServiceController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all TechService models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TechServiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TechService model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $model->equipmentIds = ArrayHelper::getColumn($model->equipmentTechServices, 'equipment_id');
        return $this->render('view', [
            'model' => $model,
            'equipmentTechService' => new EquipmentTechService()
        ]);
    }

    /**
     * Creates a new TechService model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TechService();

        if (Yii::$app->request->isAjax && $this->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->asJson(['success' => true]);
            }

            $result = [];

            foreach ($model->getErrors() as $attribute => $errors) {
                $result[Html::getInputId($model, $attribute)] = $errors;
            }

            return $this->asJson(['validation' => $result]);
        } else if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TechService model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax) {
            if ($this->request->isPost) {
                if ($model->load($this->request->post()) && $model->save()) {
                    return $this->asJson(['success' => true]);
                }

                $result = [];

                foreach ($model->getErrors() as $attribute => $errors) {
                    $result[Html::getInputId($model, $attribute)] = $errors;
                }

                return $this->asJson(['validation' => $result]);
            }

            return $this->renderAjax('_update_tech_service', [
                'model' => $model
            ]);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TechService model.
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

    public function actionAssignEquipment()
    {
        if (Yii::$app->request->isAjax && $this->request->isPost) {
            $oldEquipmentIds = [];
            $id = $_POST['TechService']['id'];
            $equipmentIds = !empty($_POST['TechService']['equipmentIds']) ? $_POST['TechService']['equipmentIds'] : [];
            $model = $this->findModel($id);

            $oldEquipmentIds = ArrayHelper::getColumn($model->equipmentTechServices, 'equipment_id');
            $deletedEquipmentIds = array_diff($oldEquipmentIds, $equipmentIds);
            $newEquipmentIds = array_diff($equipmentIds, $oldEquipmentIds);

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $flag = true;
                if (!empty($deletedEquipmentIds))
                    EquipmentTechService::deleteAll(['equipment_id' => $deletedEquipmentIds, 'tech_service_id' => $id]);

                foreach ($newEquipmentIds as $equipmentId) {
                    $eqTechService = new EquipmentTechService();
                    $eqTechService->tech_service_id = $id;
                    $eqTechService->equipment_id = $equipmentId;
                    if (!$flag = $eqTechService->save()) {
                        break;
                    }
                }

                if ($flag) {
                    $transaction->commit();
                    return $this->asJson([
                        'success' => true,
                        'equipmentIds' => ArrayHelper::getColumn($model->getEquipmentTechServices()->all(), 'equipment_id')
                    ]);
                } else {
                    $transaction->rollBack();
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Finds the TechService model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return TechService the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TechService::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
