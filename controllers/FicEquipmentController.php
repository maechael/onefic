<?php

namespace app\controllers;

use app\models\EquipmentIssue;
use app\models\EquipmentIssueRepairSearch;
use app\models\EquipmentIssueSearch;
use app\models\FicEquipment;
use app\models\FicEquipmentSearch;
use app\models\MaintenanceChecklistLog;
use app\models\MaintenanceChecklistLogSearch;
use Yii;
use yii\bootstrap4\Html;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class FicEquipmentController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $searchModel = new FicEquipmentSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionView($id)
    {
        $ficEquipment = $this->findFicEquipment($id);
        $equipmentIssues = $ficEquipment->getEquipmentIssues()->orderBy(['updated_at' => SORT_DESC])->limit(5)->all();
        $checklistLogs = $ficEquipment->getMaintenanceChecklistLogs()->orderBy(['accomplished_by_date' => SORT_DESC])->limit(5)->all();

        $issueCountDatasets = $ficEquipment->getIssueCountDatasets();
        $repairCountDatasets = $ficEquipment->getRepairCountDatasets();
        $componentIssueCountDatasets = $ficEquipment->getComponentIssueCountDatasets();
        $partIssueCountDatasets = $ficEquipment->getPartIssueCountDatasets();

        return $this->render('view', [
            'ficEquipment' => $ficEquipment,
            'equipmentIssues' => $equipmentIssues,
            'checklistLogs' => $checklistLogs,

            'issueCountDatasets' => $issueCountDatasets,
            'repairCountDatasets' => $repairCountDatasets,
            'componentIssueCountDatasets' => $componentIssueCountDatasets,
            'partIssueCountDatasets' => $partIssueCountDatasets,
        ]);
    }

    public function actionIssues($id)
    {
        $searchModel = new EquipmentIssueSearch();
        $params = ArrayHelper::merge($this->request->queryParams, ['EquipmentIssueSearch' => ['fic_equipment_id' => $id]]);
        $dataProvider = $searchModel->search($params);
        return $this->render('issues', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'ficEquipment' => $this->findFicEquipment($id)
        ]);
    }

    public function actionIssue($id)
    {
        $request = Yii::$app->request;
        $equipmentIssue = $this->findEquipmentIssue($id);
        if ($request->isAjax) {
            // Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return $this->renderAjax('_issue', [
                    'equipmentIssue' => $equipmentIssue
                ]);
            }
        } else {
            return $this->render('issue', [
                'equipmentIssue' => $equipmentIssue
            ]);
        }
    }

    public function actionRepairs($id)
    {
        $searchModel = new EquipmentIssueRepairSearch();
        // $params = ArrayHelper::merge($this->request->queryParams, ['EquipmentIssueRepairSearch' => ['fic_equipment_id' => $id]]);
        $dataProvider = $searchModel->search($this->request->queryParams);
        return $this->render('repairs', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'equipmentIssue' => $this->findEquipmentIssue($id)
        ]);
    }

    public function actionMaintenanceChecklistLogs($id)
    {
        $ficEquipment = $this->findFicEquipment($id);
        $searchModel = new MaintenanceChecklistLogSearch();
        $params = ArrayHelper::merge($this->request->queryParams, ['MaintenanceChecklistLogSearch' => ['fic_equipment_id' => $id]]);
        $dataProvider = $searchModel->search($params);

        return $this->render('maintenance-checklist-logs', [
            'ficEquipment' => $ficEquipment,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    protected function findEquipmentIssue($id)
    {
        if (($model = EquipmentIssue::findOne($id)) !== null) {
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
