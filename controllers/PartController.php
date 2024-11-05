<?php

namespace app\controllers;

use app\models\Metadata;
use Yii;
use app\models\Part;
use app\models\PartSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\UploadedFile;

/**
 * PartController implements the CRUD actions for Part model.
 */
class PartController extends Controller
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
     * Lists all Part models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PartSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Part model.
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
     * Creates a new Part model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Part();

        if (Yii::$app->request->isAjax && $this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                if ($model->imageFile)
                    $model->uploadImage(false, Yii::$app->params["part_folder"]);
                if ($model->save())
                    return $this->asJson(['success' => true]);
            }


            $result = [];

            foreach ($model->getErrors() as $attribute => $errors) {
                $result[Html::getInputId($model, $attribute)] = $errors;
            }

            return $this->asJson(['validation' => $result]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Part model.
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
                if ($model->load($this->request->post())) {
                    $oldImage = $this->findImage($model->media_id);
                    if ($model->isImageChanged == 1) {
                        $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                        if ($model->imageFile) {
                            //..if there's no initial image
                            if (!isset($model->media_id) || $model->media_id == null) {
                                $model->uploadImage(false, Yii::$app->params["part_folder"]);
                            } else {
                                //..delete old image in uploads
                                // unlink($oldImage->filepath);

                                //..upload new image in uploads          
                                //..update info in metadata table
                                $model->uploadImage(true, Yii::$app->params["part_folder"]);
                            }
                        } else if (!$model->imageFile && isset($model->media_id)) {
                            $oldImage->delete();
                            $model->media_id = null;
                        }
                    }

                    if ($model->save())
                        return $this->asJson(['success' => true]);
                }

                $result = [];

                foreach ($model->getErrors() as $attribute => $errors) {
                    $result[Html::getInputId($model, $attribute)] = $errors;
                }

                return $this->asJson(['validation' => $result]);
            }

            return $this->renderAjax('_update_part', [
                'model' => $model,
            ]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Part model.
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
     * Finds the Part model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Part the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Part::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findImage($id)
    {
        if (($image = Metadata::findOne($id)) !== null) {
            return $image;
        }

        return null;
    }
}
