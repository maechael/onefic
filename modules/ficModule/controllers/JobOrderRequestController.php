<?php

namespace app\modules\ficModule\controllers;

use Yii;
use app\models\JobOrderRequest;
use app\modules\ficModule\models\JobOrderRequestSearch;
use Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * JobOrderRequestController implements the CRUD actions for JobOrderRequest model.
 */
class JobOrderRequestController extends Controller
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
     * Lists all JobOrderRequest models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new JobOrderRequestSearch();
        $userProfile = Yii::$app->user->identity->userProfile;
        $dataProvider = $searchModel->searchMyPending(Yii::$app->request->queryParams, $userProfile->fic_affiliation);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single JobOrderRequest model.
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
     * Creates a new JobOrderRequest model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new JobOrderRequest();
        $userProfile = Yii::$app->user->identity->userProfile;
        $model->fic_id = $userProfile->fic_affiliation;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing JobOrderRequest model.
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
     * Deletes an existing JobOrderRequest model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        // $this->findModel($id)->delete();
        $model = $this->findModel($id);
        $model->status = JobOrderRequest::STATUS_CANCELLED;

        if ($model->save())
            return $this->redirect(['index']);

        throw new Exception('shit nagerror exception');
    }

    /**
     * Finds the JobOrderRequest model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return JobOrderRequest the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = JobOrderRequest::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionForApproval()
    {
        $searchModel = new JobOrderRequestSearch();
        $userProfile = Yii::$app->user->identity->userProfile;
        $dataProvider = $searchModel->searchMyPending(Yii::$app->request->queryParams, $userProfile->fic_affiliation);

        return $this->render('for-approval', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionExpandApprovalDetails()
    {
        if (isset($_POST['expandRowKey'])) {
            $model = JobOrderRequest::findOne($_POST['expandRowKey']);
            return $this->renderPartial('_expand-row-details', ['model' => $model]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    public function actionApproveDecline($id)
    {
        return $this->render('approve-decline', [
            'model' => $this->findModel($id)
        ]);
    }

    public function actionApprove()
    {
        return null;
    }

    public function actionDecline()
    {
        return null;
    }
}
