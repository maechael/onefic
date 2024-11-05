<?php

namespace app\modules\supplierModule\controllers;

use app\models\Branch;
use app\models\Metadata;
use app\models\Model;
use app\models\PartSupplier;
use Yii;
use app\models\Supplier;
use app\models\SupplierMedia;
use app\models\SupplierSearch;
use dominus77\sweetalert2\Alert;
use Exception;
use yii\bootstrap4\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * SupplierController implements the CRUD actions for Supplier model.
 */
class SupplierController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Supplier models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SupplierSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionApproval()
    {

        $searchModel = new SupplierSearch();
        $dataProvider = $searchModel->searchPending($this->request->queryParams);
        $supplier = new Supplier();
        return $this->render('approval', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'supplier' => $supplier,
        ]);
    }

    public function actionRejectStatus($id)
    {
        $model = $this->findmodel($id);
        $model->approval_status = Supplier::APPROVAL_STATUS_REJECTED;
        $model->save($id);
        Yii::$app->session->setFlash(Alert::TYPE_SUCCESS, [
            'title' => 'REJECTED',
            'text' => "{$model->organization_name} has been rejected",
        ]);
        return $this->redirect('approval');
    }

    public function actionApproveStatus($id)
    {

        $model = $this->findModel($id);
        $model->approval_status = Supplier::APPROVAL_STATUS_APPROVED;
        $model->save($id);
        Yii::$app->session->setFlash(Alert::TYPE_SUCCESS, [
            'title' => 'APPROVED',
            'text' => "{$model->organization_name} has been approved",
        ]);
        return $this->redirect('approval');
    }
    /**
     * Displays a single Supplier model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $supplier = $this->findModel($id);
        $filePreviews = [];
        $previewConfigs = [];
        //..shortcut version of getting filepaths as array
        // $filePreviews = ArrayHelper::getColumn($supplier->medias, 'filepath');
        foreach ($supplier->medias as $media) {
            $filePreviews[] = $media->link;
            $previewConfigs[] = array("type" => $media->previewType, "caption" => $media->basename, "key" => $media->id);
        }

        return $this->render('view', [
            'model' => $supplier,
            'filePreviews' => $filePreviews,
            'previewConfigs' => $previewConfigs
        ]);
    }

    public function actionGetSupplier($id)
    {
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new Supplier model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $supplier = new Supplier();
        $branches = [new Branch(['scenario' => Branch::SCENARIO_SETUP])];

        if ($this->request->isPost && $supplier->load(Yii::$app->request->post())) {
            $supplier->businessFiles = UploadedFile::getInstances($supplier, 'businessFiles');

            if ($valid = $supplier->validate()) {
                $branches = Model::createMultiple(Branch::class, $branches, Branch::SCENARIO_SETUP);
                Model::loadMultiple($branches, $this->request->post());
                $valid = $valid && Model::validateMultiple($branches);
            }

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    // $supplier->approval_status = Supplier::APPROVAL_STATUS_APPROVED;
                    $flag = $supplier->save(false);

                    //..supplier parts saving block
                    if ($flag && !empty($supplier->partsField)) {
                        foreach ($supplier->partsField as $partId) {
                            $partSupplier = new PartSupplier();
                            $partSupplier->supplier_id = $supplier->id;
                            $partSupplier->part_id = $partId;
                            if (!$flag = $flag && $partSupplier->save())
                                break;
                        }
                    }

                    //..supplier media files saving block
                    if ($flag) {
                        foreach ($supplier->businessFiles as $businessFile) {
                            $media = new Metadata();
                            $media->set($businessFile, Yii::$app->params["supplier_folder"]);

                            if ($flag = $flag && $media->save()) {
                                $supplierMedia = new SupplierMedia();
                                $supplierMedia->media_type = SupplierMedia::MEDIA_TYPE_BUSINESS_FILE;
                                $supplierMedia->supplier_id = $supplier->id;
                                $supplierMedia->media_id = $media->id;

                                if ($flag = $flag && $supplierMedia->save()) {
                                    $flag = $media->upload($businessFile);
                                } else {
                                    break;
                                }
                            } else {
                                break;
                            }
                        }
                    }

                    if ($flag) {
                        foreach ($branches as $i => $branch) {
                            $branch->supplier_id = $supplier->id;
                            $branch->businessFiles = UploadedFile::getInstances($branch, "[{$i}]businessFiles");

                            if ($flag = $flag && $branch->save(false)) {
                                foreach ($branch->businessFiles as $businessFile) {
                                    $media = new Metadata();
                                    $media->set($businessFile, Yii::$app->params["supplier_folder"]);

                                    if ($flag = $flag && $media->save()) {
                                        $branchMedia = new SupplierMedia();
                                        $branchMedia->media_type = SupplierMedia::MEDIA_TYPE_BUSINESS_FILE;
                                        $branchMedia->supplier_id = $supplier->id;
                                        $branchMedia->branch_id = $branch->id;
                                        $branchMedia->media_id = $media->id;

                                        if ($flag = $flag && $branchMedia->save()) {
                                            $flag = $flag && $media->upload($businessFile);
                                        } else {
                                            break;
                                        }
                                    } else {
                                        break;
                                    }
                                }
                            } else {
                                break;
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect('index');
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        } else {
            $supplier->loadDefaultValues();
        }

        return $this->render('create', [
            'supplier' => $supplier,
            'branches' => $branches
        ]);
    }

    /**
     * Updates an existing Supplier model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $supplier = $this->findModel($id);
        $supplier->partsField = ArrayHelper::getColumn($supplier->partSuppliers, 'part_id');
        $branches = empty($supplier->branches) ? [new Branch] : $supplier->branches;
        $oldPartIds = $supplier->partsField;
        $addedPartIds = $oldBranchIds = $deletedBranchIds = $deletedPartIds = $filePreviews = $previewConfigs = [];
        $session = Yii::$app->session;

        foreach ($supplier->myMedias as $media) {
            $filePreviews[] = $media->link;
            $previewConfigs[] = array("type" => $media->previewType, "caption" => $media->basename, "key" => $media->id);
        }

        if ($this->request->isPost && $supplier->load(Yii::$app->request->post())) {
            //..removed media ids are stored in session variable: 'media.ids'
            $deletedMediaIds = $session->get('media.ids');
            $supplier->businessFiles = UploadedFile::getInstances($supplier, 'businessFiles');

            if ($valid = $supplier->validate()) {
                //..branches loading and validating block
                $oldBranchIds = ArrayHelper::map($branches, 'id', 'id');
                $branches = Model::createMultiple(Branch::class, $branches, Branch::SCENARIO_SETUP);
                Model::loadMultiple($branches, $this->request->post());
                $deletedBranchIds = array_diff($oldBranchIds, array_filter(ArrayHelper::map($branches, 'id', 'id')));

                if ($valid = $valid && Model::validateMultiple($branches)) {
                    $deletedPartIds = array_diff($oldPartIds, $supplier->partsField == "" ? [] : $supplier->partsField);
                    $addedPartIds = array_diff($supplier->partsField == "" ? [] : $supplier->partsField, $oldPartIds);
                }
            }

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if (!empty($deletedBranchIds)) {
                        $dBranches = $supplier->getBranches()->andWhere(['id' => $deletedBranchIds]);
                        foreach ($dBranches->each() as $branch) {
                            if (!$flag = $branch->delete())
                                break;
                        }
                    }

                    if (!empty($deletedPartIds)) {
                        PartSupplier::deleteAll(['part_id' => $deletedPartIds]);
                    }

                    if (!empty($deletedMediaIds)) {
                        $medias = Metadata::findAll(['id' => $deletedMediaIds]);
                        foreach ($medias as $media) {
                            // $media->deleteMedia();
                            $media->delete();
                        }
                    }

                    //..supplier parts saving block
                    if ($flag = $supplier->save(false)) {
                        foreach ($addedPartIds as $partId) {
                            $partSupplier = new PartSupplier();
                            $partSupplier->supplier_id = $supplier->id;
                            $partSupplier->part_id = $partId;
                            if (!$flag = $flag && $partSupplier->save())
                                break;
                        }
                    }

                    //..supplier media files saving block
                    if ($flag) {
                        foreach ($supplier->businessFiles as $businessFile) {
                            $media = new Metadata();
                            $media->set($businessFile, Yii::$app->params["supplier_folder"]);

                            if ($flag = $flag && $media->save()) {
                                $supplierMedia = new SupplierMedia();
                                $supplierMedia->media_type = SupplierMedia::MEDIA_TYPE_BUSINESS_FILE;
                                $supplierMedia->supplier_id = $supplier->id;
                                $supplierMedia->media_id = $media->id;

                                if ($flag = $flag && $supplierMedia->save()) {
                                    $flag = $media->upload($businessFile);
                                } else {
                                    break;
                                }
                            } else {
                                break;
                            }
                        }
                    }

                    //..branches saving block
                    if ($flag) {
                        foreach ($branches as $i => $branch) {
                            $branch->supplier_id = $supplier->id;
                            $branch->businessFiles = UploadedFile::getInstances($branch, "[{$i}]businessFiles");

                            if ($flag = $flag && $branch->save(false)) {
                                foreach ($branch->businessFiles as $businessFile) {
                                    $media = new Metadata();
                                    $media->set($businessFile, Yii::$app->params["supplier_folder"]);

                                    if ($flag = $flag && $media->save()) {
                                        $branchMedia = new SupplierMedia();
                                        $branchMedia->media_type = SupplierMedia::MEDIA_TYPE_BUSINESS_FILE;
                                        $branchMedia->supplier_id = $supplier->id;
                                        $branchMedia->branch_id = $branch->id;
                                        $branchMedia->media_id = $media->id;

                                        if ($flag = $flag && $branchMedia->save()) {
                                            $flag = $flag && $media->upload($businessFile);
                                        } else {
                                            break;
                                        }
                                    } else {
                                        break;
                                    }
                                }
                            } else {
                                break;
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect('index');
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        } else {
            $session->remove('media.ids');
        }

        return $this->render('update', [
            'supplier' => $supplier,
            'filePreviews' => $filePreviews,
            'previewConfigs' => $previewConfigs,
            'branches' => $branches
        ]);
    }

    /**
     * Deletes an existing Supplier model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->softDelete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Supplier model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Supplier the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Supplier::findOne($id)) !== null) {
            $model->province_id = $model->municipalityCity->province_id;
            $model->region_id = $model->municipalityCity->region_id;
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
