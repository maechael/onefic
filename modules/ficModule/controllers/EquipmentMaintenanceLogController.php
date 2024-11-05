<?php

namespace app\modules\ficModule\controllers;

use Yii;
use app\models\EquipmentMaintenanceLog;
use app\models\EquipmentMaintenanceLogSearch;
use app\models\MaintenanceLogComponentPart;
use app\models\Model;
use app\modules\ficModule\models\FicEquipment;
use Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EquipmentMaintenanceLogController implements the CRUD actions for EquipmentMaintenanceLog model.
 */
class EquipmentMaintenanceLogController extends Controller
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
     * Lists all EquipmentMaintenanceLog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EquipmentMaintenanceLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EquipmentMaintenanceLog model.
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
     * Creates a new EquipmentMaintenanceLog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EquipmentMaintenanceLog();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing EquipmentMaintenanceLog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing EquipmentMaintenanceLog model.
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

    public function actionMaintain($id)
    {
        $ficEquipment = $this->findFicEquipment($id);
        $equipmentComponents = $ficEquipment->equipment->equipmentComponents;
        $maintenanceLogModel = new EquipmentMaintenanceLog();
        $logComponentParts = [];

        if ($this->request->isPost) {
            if ($maintenanceLogModel->load($this->request->post())) {
                $valid = $maintenanceLogModel->validate();

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if (!$flag = $maintenanceLogModel->save(false)) {
                        $transaction->rollBack();
                        return;
                    }

                    if (isset($_POST['MaintenanceLogComponentPart'][0][0])) {
                        foreach ($_POST['MaintenanceLogComponentPart'] as $i => $logComponentParts) {
                            foreach ($logComponentParts as $partLog) {
                                $data['MaintenanceLogComponentPart'] = $partLog;
                                $logPart = new MaintenanceLogComponentPart();
                                $logPart->load($data);
                                $logPart->equipment_maintenance_log_id = $maintenanceLogModel->id;

                                $valid = $logPart->validate() && $valid;
                                if (!$flag = $logPart->save(false)) {
                                    $transaction->rollBack();
                                    break;
                                }
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect([
                            'maintenance-list', 'fic_equipment_id' => $ficEquipment->id
                        ]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }



        $maintenanceLogModel->fic_equipment_id = $id;

        foreach ($equipmentComponents as $iec => $equipmentComponent) {
            foreach ($equipmentComponent->equipmentComponentParts as $iecp => $equipmentComponentPart) {
                $logPart = new MaintenanceLogComponentPart();
                $logPart->isOperational = MaintenanceLogComponentPart::IS_OPERATIONAL_YES;
                $logPart->isInspected = MaintenanceLogComponentPart::IS_INSPECTED_YES;
                $logPart->equipment_component_part_id = $equipmentComponentPart->id;
                $logPart->equipment_component_id = $equipmentComponentPart->equipmentComponent->id;
                $logComponentParts[$iec][$iecp] = $logPart;
            }
        }

        return $this->render('maintain', [
            'ficEquipment' => $ficEquipment,
            'equipmentComponents' => $equipmentComponents,
            'maintenanceLogModel' => $maintenanceLogModel,
            'logComponentParts' => $logComponentParts
        ]);
    }

    public function actionMaintainUpdate($id)
    {
        $equipmentMaintenanceLog = $this->findModel($id);
        $maintenanceLogComponentParts = $equipmentMaintenanceLog->maintenanceLogComponentParts;

        if ($this->request->isPost && $equipmentMaintenanceLog->load($this->request->post())) {
            $maintenanceLogComponentParts = Model::createMultiple(MaintenanceLogComponentPart::class, $maintenanceLogComponentParts);
            Model::loadMultiple($maintenanceLogComponentParts, $this->request->post());

            $valid = $equipmentMaintenanceLog->validate();
            $valid = Model::validateMultiple($maintenanceLogComponentParts) && $valid;

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $flag = $equipmentMaintenanceLog->save(false);

                    if ($flag) {
                        foreach ($maintenanceLogComponentParts as $i => $logComponentPart) {
                            if (!$flag = $logComponentPart->save(false))
                                break;
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect([
                            'maintenance-list', 'fic_equipment_id' => $equipmentMaintenanceLog->fic_equipment_id
                        ]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('maintain-update', [
            'equipmentMaintenanceLog' => $equipmentMaintenanceLog,
            'maintenanceLogComponentParts' => $maintenanceLogComponentParts,
        ]);
    }

    public function actionMaintenanceList()
    {
        $request = Yii::$app->request;
        $searchModel = new EquipmentMaintenanceLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $fic_equipment_id = $request->getQueryParam('fic_equipment_id');

        if ($fic_equipment_id != null)
            $dataProvider->query->filterWhere(['fic_equipment_id' => $fic_equipment_id]);

        return $this->render('maintenance-list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'ficEquipment' => $this->findFicEquipment($fic_equipment_id),
        ]);
    }

    /**
     * Finds the EquipmentMaintenanceLog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return EquipmentMaintenanceLog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EquipmentMaintenanceLog::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findFicEquipment($id)
    {
        if (($model = FicEquipment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
