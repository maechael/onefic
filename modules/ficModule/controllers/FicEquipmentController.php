<?php

namespace app\modules\ficModule\controllers;

use app\models\Equipment;
use app\models\EquipmentIssue;
use app\models\EquipmentIssueSearch;
use Yii;
use app\modules\ficModule\models\FicEquipment;
use app\modules\ficModule\models\FicEquipmentSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;

/**
 * FicEquipmentController implements the CRUD actions for FicEquipment model.
 */
class FicEquipmentController extends Controller
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
                    'issues' => ['POST', 'GET']
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'issues', 'issue', 'create-issue'],
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all FicEquipment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FicEquipmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'fic' => Yii::$app->user->identity->userProfile->fic,
            'ficEquipment' => new FicEquipment(),
            'equipments' => Equipment::getEquipments()
        ]);
    }

    /**
     * Displays a single FicEquipment model.
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
     * Creates a new FicEquipment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FicEquipment();

        if (Yii::$app->request->isAjax && $this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->fic_id = Yii::$app->user->identity->userProfile->fic_affiliation;
                if ($model->save()) {
                    return $this->asJson(['success' => true]);
                }
            }

            $result = [];

            foreach ($model->getErrors() as $attribute => $errors) {
                $result[Html::getInputId($model, $attribute)] = $errors;
            }

            return $this->asJson(['validation' => $result]);
        }

        return $this->render('create', [
            'model' => $model,
            'equipments' => Equipment::getEquipments()
        ]);
    }

    /**
     * Updates an existing FicEquipment model.
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
            'equipments' => Equipment::getEquipments()
        ]);
    }

    /**
     * Deletes an existing FicEquipment model.
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
     * Finds the FicEquipment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return FicEquipment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FicEquipment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findIssue($id)
    {
        if (($issue = EquipmentIssue::findOne($id)) !== null) {
            return $issue;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionIssues()
    {
        $request = Yii::$app->request;
        $searchModel = new EquipmentIssueSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $fic_equipment_id = $request->getQueryParam('fic_equipment_id');

        if ($fic_equipment_id != null) {
            $dataProvider->query->andFilterWhere(['fic_equipment_id' => $fic_equipment_id]);
        } else {
            $fic_equipment_id = $request->getQueryParam('EquipmentIssueSearch')['fic_equipment_id'];
        }

        // $fic_equipment_id = $fic_equipment_id != null ? $fic_equipment_id : $request->getQueryParam('EquipmentIssueSearch')['fic_equipment_id'];

        return $this->render('issues', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'ficEquipment' => $this->findModel($fic_equipment_id)
        ]);
    }

    public function actionIssue($id)
    {
        $issue = $this->findIssue($id);
        return $this->render('issue', [
            'issue' => $issue
        ]);
    }

    public function actionCreateIssue()
    {
        $issue = new EquipmentIssue();
        if (Yii::$app->request->isAjax) {
            if ($issue->load($this->request->post()) && $issue->save()) {
                return $this->asJson(['success' => true]);
            }

            $result = [];

            foreach ($issue->getErrors() as $attribute => $errors) {
                $result[Html::getInputId($issue, $attribute)] = $errors;
            }

            return $this->asJson(['validation' => $result]);
        }
        return null;
    }
}
