<?php

namespace app\controllers;

use app\models\Equipment;
use app\models\Metadata;
use app\models\Product;
use app\models\ProductEquipment;
use app\models\ProductMedia;
use app\models\ProductSearch;
use Exception;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
     * Lists all Product models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $model = new Product();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }

    /**
     * Displays a single Product model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $filePreviews = [];
        $previewConfig = [];
        foreach ($model->productMedias as $media) {
            $filePreviews[] = $media->media->link;
            $previewConfig[] = array("type" => $media->media->previewType, "caption" => $media->media->basename, "key" => $media->media->id);
        }
        return $this->render('view', [
            'model' => $model,
            'filePreviews' => $filePreviews,
            'previewConfigs' => $previewConfig
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Product();
        if ($this->request->isPost) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($model->load($this->request->post()) && $model->save()) {
                    $model->productImages = UploadedFile::getInstances($model, 'productImages');

                    if (is_array($model->equipmentIds)) {
                        foreach ($model->equipmentIds as $i => $equipmenId) {
                            $productEquipment = new ProductEquipment();
                            $productEquipment->equipment_id = $equipmenId;
                            $productEquipment->product_id = $model->id;
                            $productEquipment->save();
                        }

                        foreach ($model->productImages as $j => $productImage) {
                            $media = new Metadata();
                            $media->set($productImage, Yii::$app->params["product_image_folder"]);
                            $media->save();
                            $productMedia = new ProductMedia();
                            $productMedia->media_id = $media->id;
                            $productMedia->product_id = $model->id;
                            $productMedia->save();
                            $media->upload($productImage);
                        }
                    }
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $oldEquipmentsIds = [];
        $model = $this->findModel($id);
        // $productEquipment = ProductEquipment::find()->where(['product_id' => $id])->all();
        $model->equipmentIds = ArrayHelper::getColumn($model->productEquipments, 'equipment_id');
        $oldEquipmentsIds = $model->equipmentIds;
        $session = Yii::$app->session;
        $filePreviews = [];
        $previewConfigs = [];
        foreach ($model->productMedias as $media) {
            $filePreviews[] = $media->media->link;
            $previewConfigs[] = array("type" => $media->media->previewType, "caption" => $media->media->basename, "key" => $media->media->id);
        }

        $transaction = Yii::$app->db->beginTransaction();

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            try {
                $deletedEquipmentIds = array_diff($oldEquipmentsIds, $_POST['Product']['equipmentIds']);
                $deletedMediaIds = $session->get('media.ids');
                $newEquipmentIds = array_diff($_POST['Product']['equipmentIds'], $oldEquipmentsIds);

                if (!empty($deletedEquipmentIds)) {
                    ProductEquipment::deleteAll(['equipment_id' => $deletedEquipmentIds, 'product_id' => $id]);
                }


                // media deletion block
                if (!empty($deletedMediaIds)) {
                    $medias = Metadata::findAll(['id' => $deletedMediaIds]);
                    foreach ($medias as $media) {
                        // $media->deleteMedia();
                        $media->delete();
                    }
                }

                foreach ($newEquipmentIds as $equipmentId) {
                    $productEquipment = new ProductEquipment();
                    $productEquipment->equipment_id = $equipmentId;
                    $productEquipment->product_id = $model->id;
                    $productEquipment->save();
                }
                $model->productImages = UploadedFile::getInstances($model, 'productImages');
                foreach ($model->productImages as $productImage) {
                    $media = new Metadata();
                    $media->set($productImage, Yii::$app->params["product_image_folder"]);
                    $media->save();
                    $productMedia = new ProductMedia();
                    $productMedia->media_id = $media->id;
                    $productMedia->product_id = $model->id;
                    $productMedia->save();
                    $media->upload($productImage);
                }


                // foreach ($model->equipmentIds as $i => $equipmenId) {
                //     $productEquipment = new ProductEquipment();
                //     $productEquipment->product_id = $model->id;
                //     $productEquipment->equipment_id = $equipmenId;
                //     $productEquipment->save();
                // }

                $transaction->commit();
                return $this->redirect(['view', 'id' => $model->id]);
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }




        return $this->render('update', [
            'model' => $model,
            'filePreviews' =>  $filePreviews,
            'previewConfigs' => $previewConfigs

        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model =  $this->findModel($id);
        $productMedias = $model->productMedias;
        foreach ($productMedias as $i => $productMedia) {
            $media = Metadata::findOne(['id' => $productMedia->media_id]);
            $media->delete();
        }
        $model->delete();

        // $medias = Metadata::find()->where(['id' => $mediaIds])->all();
        // 

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
